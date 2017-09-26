
CREATE TABLE account (
	email VARCHAR (255) PRIMARY KEY,
	NAME VARCHAR (255),
	password VARCHAR (255),
	is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE project (
	project_id serial PRIMARY KEY,
	advertiser VARCHAR (255) REFERENCES account (email),
	title VARCHAR (255),
	description TEXT,
	start_date DATE,
	end_date DATE,
	keywords VARCHAR (255),
	amount_sought NUMERIC
);

CREATE TABLE fund (
	fund_id serial PRIMARY KEY,
	investor VARCHAR (255) REFERENCES account (email),
	projectid serial REFERENCES project (project_id),
	amount NUMERIC
);


