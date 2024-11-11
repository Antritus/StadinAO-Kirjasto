CREATE TABLE accounts(
    userid  INT NOT NULL,
    name VARCHAR(36) NOT NULL,
    sName VARCHAR(36) NOT NULL,
    address VARCHAR(100) NOT NULL,
    postcode INT NOT NULL,
    postArea VARCHAR(50) NOT NULL,
    birthday VARCHAR(11) NOT NULL,
    email VARCHAR(150) NOT NULL,
    accountName VARCHAR(20) NOT NULL,
    pswd VARCHAR(1000) NOT NULL,
    permission INT DEFAULT 0 NOT NULL,
    PRIMARY KEY (userid)
);
