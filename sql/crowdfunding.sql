
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
	amount_sought NUMERIC check(amount_sought > 0) NOT NULL
);

CREATE TABLE fund (
	fund_id serial PRIMARY KEY,
	investor VARCHAR (255) REFERENCES account (email),
	project_id serial REFERENCES project (project_id),
	amount NUMERIC check(amount > 0) NOT NULL
);


