drop table occured_on;
drop table work_on;
drop table developers;
drop table fix;
drop table software;
drop table bugs_has_detail;
drop table bugs_has_main;
drop table fetch;
drop table has_gpu;
drop table gpu_details2;
drop table gpu_details1;
drop table gpu_main_part;
drop table has_ram;
drop table ram_card;
drop table pc_run_has_cpu;
drop table cpu_details2;
drop table cpu_details1;
drop table cpu_main_part;
drop table software_testing_team;
drop table hardware;
drop table operating_system;

create table operating_system(
    version char(20),
    os_type char(20),
    primary key (version, os_type)
);

create table hardware(
    uuid char(20),
    primary key (uuid)
);

create table software_testing_team(
    tester_id char(20),
    name char(20),
    primary key (tester_id)
);


create table cpu_main_part(
    cpu_model_number char(20),
    uuid char(20),
    primary key (cpu_model_number, uuid),
    foreign key (uuid) references hardware ON DELETE CASCADE
);

create table cpu_details1(
    cpu_model_number char(20),
    cpu_generation char(20),
    cpu_code_name char(20),
    cpu_brand_name char(20),
    primary key (cpu_model_number)
);

create table cpu_details2(
    cpu_generation char(20),
    cpu_code_name char(20),
    cpu_brand_name char(20),
    cpu_production_date char(20),
    primary key (cpu_code_name, cpu_brand_name, cpu_generation)
);

create table pc_run_has_cpu(
    model_id char(20),
    os_type char(20) not null,
    version char(20) not null,
    cpu_model_number char(20) not null,
    uuid char(20),
    primary key (model_id),
    foreign key (version, os_type) references operating_system ON DELETE CASCADE,
    foreign key (cpu_model_number, uuid) references cpu_main_part ON DELETE CASCADE
);

create table ram_card(
    ram_model_number char(20),
    uuid char(20),
    primary key (ram_model_number, uuid),
    foreign key (uuid) references hardware ON DELETE CASCADE
);

create table has_ram(
    ram_model_number char(20),
    model_id char(20),
    uuid char(20),
    primary key (ram_model_number, model_id, uuid),
    foreign key (ram_model_number, uuid) references ram_card ON DELETE CASCADE,
    foreign key (model_id) references pc_run_has_cpu ON DELETE CASCADE
);

create table gpu_main_part(
    gpu_model_number char(20),
    uuid char(20),
    primary key (gpu_model_number, uuid),
    foreign key (uuid) references hardware ON DELETE CASCADE
);

create table gpu_details1(
    gpu_model_number char(20),
    gpu_generation char(20),
    gpu_code_name char(20),
    gpu_brand_name char(20),
    primary key (gpu_model_number)
);

create table gpu_details2(
    gpu_generation char(20),
    gpu_code_name char(20),
    gpu_brand_name char(20),
    gpu_production_date char(20),
    primary key (gpu_code_name, gpu_brand_name, gpu_generation)
);

create table has_gpu(
    gpu_model_number char(20),
    model_id char(20),
    uuid char(20),
    primary key (gpu_model_number, model_id, uuid),
    foreign key (gpu_model_number, uuid) references gpu_main_part ON DELETE CASCADE,
    foreign key (model_id) references pc_run_has_cpu ON DELETE CASCADE
);

create table fetch(
    uuid char(20),
    tester_id char(20),
    primary key(uuid, tester_id),
    foreign key (uuid) references hardware ON DELETE CASCADE,
    foreign key (tester_id) references software_testing_team ON DELETE CASCADE
);

create table bugs_has_main(
    bug_id char(20),
    software_name char(20),
    software_version char(20),
    primary key (bug_id, software_name, software_version)
);

create table bugs_has_detail(
    bug_id char(20),
    bug_type char(100),
    primary key (bug_id)
);

create table software(
    software_name char(20),
    software_version char(20),
    primary key (software_name, software_version)
);

create table fix(
    tester_id char(20),
    bug_id char(20),
    software_name char(20),
    software_version char(20),
    primary key (tester_id, bug_id, software_name, software_version),
    foreign key (tester_id) references software_testing_team ON DELETE CASCADE,
    foreign key (bug_id, software_name, software_version) references bugs_has_main ON DELETE CASCADE
);

create table developers (
    dev_id INTEGER,
    name char(20),
    speciality char(20),
    primary key (dev_id)
);

create table work_on (
    software_name char(20),
    software_version char(20),
    dev_id INTEGER,
    foreign key (software_name, software_version) references software ON DELETE CASCADE,
    foreign key (dev_id) references developers ON DELETE CASCADE
);

create table occured_on (
    software_name char(20),
    software_version char(20),
    model_id char(20),
    bug_id char(20),
    primary key (software_name, software_version, model_id, bug_id),
    foreign key (software_name, software_version) references software,
    foreign key (model_id) references pc_run_has_cpu ON DELETE CASCADE,
    foreign key (bug_id, software_name, software_version) references bugs_has_main ON DELETE CASCADE
);

insert into operating_system values('10.1', 'Windows');
insert into operating_system values('8.0.1', 'Windows');
insert into operating_system values('11.6', 'macOS');
insert into operating_system values('0.01', 'macOS');
insert into operating_system values('14.2', 'Ubuntu');

insert into hardware values('cpu1');
insert into hardware values('cpu2');
insert into hardware values('cpu3');
insert into hardware values('cpu4');
insert into hardware values('cpu5');
insert into hardware values('gpu1');
insert into hardware values('gpu2');
insert into hardware values('gpu3');
insert into hardware values('gpu4');
insert into hardware values('gpu5');
insert into hardware values('ram1');
insert into hardware values('ram2');
insert into hardware values('ram3');
insert into hardware values('ram4');
insert into hardware values('ram5');

insert into software_testing_team values('test1', 'team 1');
insert into software_testing_team values('test2', 'team 2');
insert into software_testing_team values('test3', 'team 3');
insert into software_testing_team values('test4', 'team 4');
insert into software_testing_team values('test5', 'team 5');

insert into cpu_main_part values('i7-7700k', 'cpu1');
insert into cpu_main_part values('i5-8600k', 'cpu2');
insert into cpu_main_part values('i3-2120', 'cpu3');
insert into cpu_main_part values('ryzen 3800x', 'cpu4');
insert into cpu_main_part values('ryzen 3600x', 'cpu5');

insert into cpu_details1 values('i7-7700k', '7', 'Kaby Lake', 'Intel');
insert into cpu_details1 values('i5-8600k', '8', 'Coffee Lake', 'Intel');
insert into cpu_details1 values('i3-2120', '2', 'Sandy Bridge', 'AMD');
insert into cpu_details1 values('ryzen 3800x', '3', 'Zen 2','AMD');
insert into cpu_details1 values('ryzen 3600x', '3', 'Matisse','AMD');

insert into cpu_details2 values('7', 'Kaby Lake', 'Intel', '01012021');
insert into cpu_details2 values('8', 'Coffee Lake', 'Intel', '02131999');
insert into cpu_details2 values('2', 'Sandy Bridge', 'AMD', '06282003');
insert into cpu_details2 values('3', 'Zen 2','AMD', '01012020');
insert into cpu_details2 values('3', 'Matisse','AMD', '12312018');

insert into pc_run_has_cpu values('pc1', 'Windows', '10.1', 'i7-7700k', 'cpu1');
insert into pc_run_has_cpu values('pc2', 'Windows', '8.0.1', 'i5-8600k', 'cpu2');
insert into pc_run_has_cpu values('pc3', 'macOS', '11.6', 'i3-2120', 'cpu3');
insert into pc_run_has_cpu values('pc4', 'macOS', '0.01', 'ryzen 3800x', 'cpu4');
insert into pc_run_has_cpu values('pc5', 'Ubuntu', '14.2', 'ryzen 3600x', 'cpu5');

insert into ram_card values('HX313C9F', 'ram1');
insert into ram_card values('HX313C9FB', 'ram2');
insert into ram_card values('HX316C10FK2', 'ram3');
insert into ram_card values('HX313C9FWK2', 'ram4');
insert into ram_card values('HX313C9FW', 'ram5');

insert into has_ram values('HX313C9F', 'pc1', 'ram1');
insert into has_ram values('HX313C9FB', 'pc2', 'ram2');
insert into has_ram values('HX316C10FK2', 'pc3', 'ram3');
insert into has_ram values('HX313C9FWK2', 'pc4', 'ram4');
insert into has_ram values('HX313C9FW', 'pc5', 'ram5');

insert into gpu_main_part values('gtx1080', 'gpu1');
insert into gpu_main_part values('gtx1070', 'gpu2');
insert into gpu_main_part values('gtx970', 'gpu3');
insert into gpu_main_part values('rx6900', 'gpu4');
insert into gpu_main_part values('rx570', 'gpu5');

insert into gpu_details1 values('gtx1080', '10','GP104-400-A1', 'Nvidia');
insert into gpu_details1 values('gtx1070', '10', 'GP10x', 'Nvidia');
insert into gpu_details1 values('gtx970', '9', 'GM204', 'Nvidia');
insert into gpu_details1 values('rx6900', '6', 'Navi 2X', 'AMD');
insert into gpu_details1 values('rx570', '5', 'Polaris20 XL', 'AMD');

insert into gpu_details2 values('10','GP104-400-A1', 'Nvidia', '01012021');
insert into gpu_details2 values('10', 'GP10x', 'Nvidia', '02131999');
insert into gpu_details2 values('9', 'GM204', 'Nvidia', '06282003');
insert into gpu_details2 values('6', 'Navi 2X', 'AMD', '01012020');
insert into gpu_details2 values('5', 'Polaris20 XL', 'AMD', '12312018');

insert into has_gpu values('gtx1080', 'pc1', 'gpu1');
insert into has_gpu values('gtx1070', 'pc2', 'gpu2');
insert into has_gpu values('gtx970', 'pc3', 'gpu3');
insert into has_gpu values('rx6900', 'pc4', 'gpu4');
insert into has_gpu values('rx570', 'pc5', 'gpu5');

insert into fetch values('gpu1', 'test1');
insert into fetch values('ram1', 'test2');
insert into fetch values('ram5', 'test3');
insert into fetch values('cpu1', 'test4');
insert into fetch values('cpu5', 'test5');

insert into bugs_has_main values('bug1', 'Internet Explorer', '0.01');
insert into bugs_has_main values('bug2', 'Visual Studio 2019', '0.02');
insert into bugs_has_main values('bug3', 'Steam', '1.0');
insert into bugs_has_main values('bug4', 'Google Chrome', '3');
insert into bugs_has_main values('bug5', 'Duck hunt', '4');

insert into bugs_has_detail values('bug1', 'web pages not loading');
insert into bugs_has_detail values('bug2', 'software crashing');
insert into bugs_has_detail values('bug3', 'UI defect');
insert into bugs_has_detail values('bug4', 'memory leak');
insert into bugs_has_detail values('bug5', 'game doesnt open');

insert into software values('Internet Explorer', '0.01');
insert into software values('Visual Studio 2019', '0.02');
insert into software values('Steam', '1.0');
insert into software values('Google Chrome', '3');
insert into software values('Duck hunt', '4');

insert into fix values('test1', 'bug1', 'Internet Explorer', '0.01');
insert into fix values('test2', 'bug2', 'Visual Studio 2019', '0.02');
insert into fix values('test3', 'bug3', 'Steam', '1.0');
insert into fix values('test4', 'bug4', 'Google Chrome', '3');
insert into fix values('test5', 'bug5', 'Duck hunt', '4');

insert into developers values(1, 'Foo', 'Backend');
insert into developers values(2, 'Bar', 'QA');
insert into developers values(3, 'baz', 'Frontend');
insert into developers values(4, 'John', 'Machine learning');
insert into developers values(5, 'Mary', 'System architecture');

insert into developers values(21, 'Rubeus', 'System');
insert into developers values(22, 'Fang', 'System');

insert into developers values(10, 'Severus', 'Backend');
insert into developers values(20, 'Tom', 'QA');
insert into developers values(30, 'Harry', 'Frontend');
insert into developers values(40, 'Ron', 'Machine learning');
insert into developers values(50, 'Hermione', 'System architecture');

insert into developers values(11, 'Albus', 'Backend');
insert into developers values(12, 'Sirius', 'QA');
insert into developers values(13, 'Draco', 'Frontend');
insert into developers values(14, 'Luna', 'Machine learning');
insert into developers values(15, 'Ginny', 'System architecture');

insert into developers values(110, 'Neville', 'Backend');
insert into developers values(120, 'Dobby', 'QA');
insert into developers values(130, 'James', 'Frontend');
insert into developers values(140, 'John', 'AI');
insert into developers values(150, 'Mary', 'GUI');

insert into work_on values('Internet Explorer', '0.01', 1);
insert into work_on values('Visual Studio 2019', '0.02', 2);
insert into work_on values('Steam', '1.0', 3);
insert into work_on values('Google Chrome', '3', 4);
insert into work_on values('Duck hunt', '4', 5);

insert into work_on values('Internet Explorer', '0.01', 5);
insert into work_on values('Steam', '1.0', 5);
insert into work_on values('Google Chrome', '3', 5);
insert into work_on values('Visual Studio 2019', '0.02', 5);

insert into work_on values('Duck hunt', '4', 20);
insert into work_on values('Internet Explorer', '0.01', 20);
insert into work_on values('Steam', '1.0', 20);
insert into work_on values('Google Chrome', '3', 20);
insert into work_on values('Visual Studio 2019', '0.02', 20);

insert into occured_on values('Internet Explorer', '0.01', 'pc1', 'bug1');
insert into occured_on values('Visual Studio 2019', '0.02', 'pc2', 'bug2');
insert into occured_on values('Steam', '1.0', 'pc3', 'bug3');
insert into occured_on values('Google Chrome', '3', 'pc4', 'bug4');
insert into occured_on values('Duck hunt', '4', 'pc5', 'bug5');

-- select speciality, count(*) from developers group by speciality having count(*) > 1;
-- SELECT d.speciality, MIN(dev_id) as MIN FROM developers d GROUP BY d.speciality HAVING 1 < (SELECT count(*) FROM developers d2 where d.dev_id = d2.dev_id);

-- SELECT d.speciality, count(dev_id) as Count, MIN(dev_id) as MIN FROM developers d GROUP BY d.speciality HAVING 2 < (SELECT count(*) FROM developers d2 where d2.speciality = d.speciality);

-- SELECT dev_id, name FROM developers D WHERE NOT EXISTS ((SELECT S.software_name FROM software S) MINUS (SELECT W.software_name FROM work_on W WHERE W.dev_id= D.dev_id));

COMMIT WORK;
