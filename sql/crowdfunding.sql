
CREATE TABLE account (
	email VARCHAR (255) PRIMARY KEY,
	NAME VARCHAR (255) NOT NULL,
	password VARCHAR (255) NOT NULL,
	is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE project (
	project_id serial PRIMARY KEY,
	advertiser VARCHAR (255) REFERENCES account (email),
	title VARCHAR (255) NOT NULL,
	description TEXT NOT NULL,
	start_date DATE NOT NULL,
	end_date DATE check(end_date > start_date) NOT NULL,
	keywords VARCHAR (255),
	amount_sought NUMERIC NOT NULL check(amount_sought) > 0
);

CREATE TABLE fund (
	fund_id serial PRIMARY KEY,
	investor VARCHAR (255) REFERENCES account (email),
	projectid serial REFERENCES project (project_id),
	amount NUMERIC NOT NULL check(amount) > 0
);


