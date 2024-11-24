CREATE TABLE item_isbn (
    id VARCHAR(100) NOT NULL,
    isbn VARCHAR(50),
    borrowed INTEGER,
    dateBorrowed VARCHAR(11),
    licenseEnds VARCHAR(11),
    description VARCHAR(250),
    PRIMARY KEY(id)
);