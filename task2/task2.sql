drop table employee;
drop table employee_info;
drop table translation;
drop table logs;


drop procedure insertEmployee;
drop procedure insertEmpInfo;
drop procedure insertContactInfo;
drop procedure insertDescription;
drop procedure insertDescriptionTranslation;
drop procedure getEmployee;
drop procedure log;


drop function getDescription;
drop function getContactInfo;

/*
drop trigger log_employee_insert;
drop trigger log_employee_info_insert;
drop trigger log_translation_insert;
drop trigger log_employee_update;
drop trigger log_employee_info_update;
drop trigger log_translation_update;
*/

####################################################################################################### CREATE

create table employee
(
    id        INT(10) unsigned primary key auto_increment,
    ssn       varchar(11)  not null,
    name      varchar(255) not null,
    active    boolean default false,
    birthdate date         not null
);

create table employee_info
(
    id        INT(10) unsigned primary key auto_increment,
    fk_emp_id int(10)      not null,
    type      varchar(255) not null,
    subtype   varchar(255) not null,
    value     text         not null
);


create table translation
(
    id             INT(10) unsigned primary key auto_increment,
    fk_emp_info_id int(10)    not null,
    language_code  varchar(2) not null,
    value          text       not null
);


create table logs
(
    log_id       INT(10) unsigned primary key auto_increment,
    created_at   timestamp default current_timestamp(),
    db_user      text      default user(),
    action       text    not null,
    table_name   text    not null,
    table_row_id int(10) not null
);

create procedure insertEmployee(
    t_ssn varchar(255),
    t_name varchar(255),
    t_active boolean,
    t_birthdate date,
    t_email text,
    t_phone text,
    t_address text,
    t_intro text,
    t_experience text,
    t_education text
)
begin
    declare emp_id int(10);

    insert into employee (ssn, name, active, birthdate) values (t_ssn, t_name, t_active, t_birthdate);
    select LAST_INSERT_ID() into emp_id;

    call insertContactInfo(emp_id, 'EMAIL', t_email);
    call insertContactInfo(emp_id, 'MOBILE_PHONE', t_phone);
    call insertContactInfo(emp_id, 'ADDRESS', t_address);
    call insertDescription(emp_id, 'INTRO', t_intro);
    call insertDescription(emp_id, 'EXPERIENCE', t_experience);
    call insertDescription(emp_id, 'EDUCATION', t_education);

    select emp_id;
end;


create procedure getEmployee(t_emp_id int(10), language_code varchar(2))
begin
    select employee.id,
           getDescription(employee.id, 'INTRO', language_code)      as intro,
           employee.name,
           getDescription(employee.id, 'EXPERIENCE', language_code) as experience,
           getDescription(employee.id, 'EDUCATION', language_code)  as education,
           getContactInfo(employee.id, 'EMAIL')                     as email,
           getContactInfo(employee.id, 'MOBILE_PHONE')              as mobile_phone,
           getContactInfo(employee.id, 'ADDRESS')                   as address,
           employee.ssn,
           employee.birthdate,
           employee.active
    from employee
    where id = t_emp_id;
end;

create procedure insertEmpInfo(t_emp_id int(10), t_type varchar(255), t_subtype varchar(255), t_value text)
begin
    insert into employee_info (fk_emp_id, type, subtype, value) values (t_emp_id, t_type, t_subtype, t_value);
end;

create procedure insertContactInfo(t_emp_id int(10), t_subtype varchar(255), t_value text)
begin
    call insertEmpInfo(t_emp_id, 'CONTACT', t_subtype, t_value);
end;

create procedure insertDescription(t_emp_id int(10), t_subtype varchar(255), t_value text)
begin
    call insertEmpInfo(t_emp_id, 'DESCRIPTION', t_subtype, t_value);
end;


create procedure insertDescriptionTranslation(t_emp_id int(10), t_lang_code varchar(2), t_subtype varchar(255),
                                              t_value text)
begin
    declare emp_info_id int(10);
    select id
    into emp_info_id
    from employee_info
    where fk_emp_id = t_emp_id
      and type = 'DESCRIPTION'
      and subtype = t_subtype;
    insert into translation (fk_emp_info_id, language_code, value) values (emp_info_id, t_lang_code, t_value);
end;

create function getContactInfo(t_emp_id int(10), t_subtype varchar(255)) returns text
begin
    declare contact_info text;
    select value into contact_info from employee_info where fk_emp_id = t_emp_id and subtype = t_subtype;
    return contact_info;
end;

create function getDescription(t_emp_id int(10), t_subtype varchar(255), t_lang_code varchar(2)) returns text
begin
    declare description_value text;

    if (t_lang_code = 'EN') then
        select value
        into description_value
        from employee_info
        where fk_emp_id = t_emp_id
          and type = 'DESCRIPTION'
          and subtype = t_subtype;
    else
        select translation.value
        into description_value
        from (
                 select id
                 from employee_info
                 where fk_emp_id = t_emp_id
                   and type = 'DESCRIPTION'
                   and subtype = t_subtype
             ) description
                 left join translation
                           on description.id = translation.fk_emp_info_id and translation.language_code = t_lang_code;
    end if;

    return description_value;
end;



create procedure log(t_method varchar(255), t_table_name varchar(255), t_row_id int(10))
begin
    insert into logs (action, table_name, table_row_id) VALUES (t_method, t_table_name, t_row_id);
end;



create trigger log_employee_insert
    after insert
    on employee
    for each row
begin
    call log('INSERT', 'employee', new.id);
end;

create trigger log_employee_info_insert
    after insert
    on employee_info
    for each row
begin
    call log('INSERT', 'employee_info', new.id);
end;

create trigger log_translation_insert
    after insert
    on translation
    for each row
begin
    call log('INSERT', 'translation', new.id);
end;



create trigger log_employee_update
    after update
    on employee
    for each row
begin
    call log('UPDATE', 'employee', new.id);
end;

create trigger log_employee_info_update
    after update
    on employee_info
    for each row
begin
    call log('UPDATE', 'employee_info', new.id);
end;

create trigger log_translation_update
    after update
    on translation
    for each row
begin
    call log('UPDATE', 'translation', new.id);
end;

####################################################################################################### CREATE END














####################################################################################################### INSERT

call insertEmployee(
        '12345678901',
        'Ken Rebane',
        0,
        '1995-05-03',
        'rebaneken95@gmail.com',
        '+3725282993',
        '123, Moon, Area 51',
        'Hello, I am ',
        'Fiddling with IT since 15 years old',
        'It systems development, Mechatronics, Business and life'
    );

call insertDescriptionTranslation(1, 'FR', 'INTRO', 'Bonjour je suis');
call insertDescriptionTranslation(1, 'FR', 'EXPERIENCE', 'Joue avec l''informatique depuis 15 ans');
call insertDescriptionTranslation(1, 'FR', 'EDUCATION', 'Développement de systèmes informatiques, mécatronique, affaires et vie');

call insertDescriptionTranslation(1, 'ES', 'INTRO', 'Hola yo soy');
call insertDescriptionTranslation(1, 'ES', 'EXPERIENCE', 'Jugando con TI desde los 15 años');
call insertDescriptionTranslation(1, 'ES', 'EDUCATION', 'Desarrollo de sistemas de TI, Mecatrónica, Negocios y vida');

call getEmployee(1, 'EN');

# select * from logs;

####################################################################################################### INSERT END
                                  /*    Lets turn this to true    */
                                  ##################################
                                     ############################
                                        ######################
                                           ################
                                              ##########
                                                 ####
                                                  ##
                                                            

                            # update employee set active = true where id = 1;

                                        # select * from logs;
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
