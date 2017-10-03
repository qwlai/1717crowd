CREATE VIEW projectview AS SELECT * FROM project;

CREATE OR REPLACE FUNCTION add_fund(_owner varchar, _title varchar, _investor varchar,  _amount numeric)
returns varchar as
$BODY$
BEGIN
IF EXISTS (SELECT owner, title FROM project WHERE owner = _owner and title = _title) THEN
INSERT INTO fund(owner, title, investor,amount) VALUES (_owner, _title, _investor, _amount);
return 'Success!';
END IF;
return 'Project does not exist!';
END;
$BODY$
language 'plpgsql' volatile;

CREATE OR REPLACE FUNCTION add_project(_advertiser varchar, _title varchar, _description text, _start_date date, _end_date date, _keywords varchar, _amount_sought numeric)
returns varchar as
$BODY$
BEGIN
IF EXISTS (SELECT a.name, p.title FROM account a, project p WHERE p.advertiser = _advertiser AND p.title = _title AND a.email = _advertiser) THEN
	return 'Project already exists!';
END IF;
INSERT INTO project(advertiser, title, description, start_date , end_date, keywords, amount_sought) VALUES (_advertiser, _title, _description, _start_date, _end_date, _keywords, _amount_sought);
return 'Project added!';
END;
$BODY$
language 'plpgsql' volatile;

CREATE OR REPLACE FUNCTION add_user(_email varchar, _name varchar, _password varchar)
returns varchar as
$BODY$
DECLARE result varchar;
BEGIN
IF EXISTS (SELECT email FROM account WHERE email = _email) THEN return _email||' already exists!';
END IF;
INSERT INTO account(email, name, password) VALUES (_email, _name, _password);
SELECT _email INTO result;
return result||' has been added to the database!';
END;
$BODY$
language 'plpgsql' volatile;

CREATE OR REPLACE FUNCTION calculate_fund(_owner varchar, _title varchar) 
returns int as
$BODY$
DECLARE result int;

BEGIN
IF EXISTS (SELECT amount FROM fund WHERE owner = _owner AND title = _title) THEN
SELECT sum(amount) FROM fund WHERE owner  = _owner AND title = _title GROUP BY _owner, _title into result;
return result;
END IF;
return 0;
END;
$BODY$
language 'plpgsql' volatile;

CREATE OR REPLACE FUNCTION update_project(_owner varchar, _oldtitle varchar, _title varchar, _description text, _end date, _keywords varchar, _amount numeric)
returns int as
$BODY$
DECLARE affected integer;

BEGIN
UPDATE project SET title=_title, description=_description, end_date=_end, keywords=_keywords, amount_sought=_amount where owner = _owner and title = _oldtitle;
GET DIAGNOSTICS affected = ROW_COUNT;
return affected;
END;
$BODY$
language 'plpgsql' volatile;
