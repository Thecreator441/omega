-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0;
SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0;
SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE =
        'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema omegas
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema omegas
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS omegas DEFAULT CHARACTER SET utf8;
USE omegas;

-- -----------------------------------------------------
-- Table acc_types
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS acc_types
(
    idacctype  INT(11)     NOT NULL AUTO_INCREMENT,
    accabbr    VARCHAR(5)  NULL DEFAULT NULL,
    labelfr    VARCHAR(50) NULL DEFAULT NULL,
    labeleng   VARCHAR(50) NULL DEFAULT NULL,
    updated_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idacctype)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table currencies
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS currencies
(
    idcurrency INT(11)     NOT NULL AUTO_INCREMENT,
    label      VARCHAR(25) NULL DEFAULT NULL,
    format     VARCHAR(10) NULL DEFAULT NULL,
    updated_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idcurrency)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table countries
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS countries
(
    idcountry  INT(11)     NOT NULL AUTO_INCREMENT,
    labelfr    VARCHAR(50) NULL DEFAULT NULL,
    labeleng   VARCHAR(50) NULL DEFAULT NULL,
    isocode    VARCHAR(5)  NULL DEFAULT NULL,
    phonecode  VARCHAR(5)  NULL DEFAULT NULL,
    currency   INT(11)     NULL DEFAULT NULL,
    updated_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idcountry),
    FOREIGN KEY (currency) REFERENCES currencies (idcurrency)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table regions
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS regions
(
    idregi     INT(11)     NOT NULL AUTO_INCREMENT,
    labeleng   VARCHAR(45) NULL DEFAULT NULL,
    labelfr    VARCHAR(45) NULL DEFAULT NULL,
    country    INT(11)     NULL DEFAULT NULL,
    updated_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idregi),
    FOREIGN KEY (country) REFERENCES countries (idcountry)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table towns
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS towns
(
    idtown      INT(11)     NOT NULL AUTO_INCREMENT,
    label       VARCHAR(45) NULL DEFAULT NULL,
    subdivision INT(11)     NULL DEFAULT NULL,
    updated_at  DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idtown),
    FOREIGN KEY (subdivision) REFERENCES sub_divs (idsub)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table networks
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS networks
(
    idnetwork  INT(11)     NOT NULL AUTO_INCREMENT,
    name       VARCHAR(50) NULL DEFAULT NULL,
    phone1     VARCHAR(25) NULL DEFAULT NULL,
    phone2     VARCHAR(25) NULL DEFAULT NULL,
    email      VARCHAR(50) NULL DEFAULT NULL,
    country    INT(11)     NULL DEFAULT NULL,
    region     INT(11)     NULL DEFAULT NULL,
    town       INT(11)     NULL DEFAULT NULL,
    address    VARCHAR(50) NULL DEFAULT NULL,
    postcode   INT(11)     NULL DEFAULT NULL,
    updated_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idnetwork),
    FOREIGN KEY (country) REFERENCES countries (idcountry),
    FOREIGN KEY (region) REFERENCES regions (idregi),
    FOREIGN KEY (town) REFERENCES towns (idtown)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table zones
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS zones
(
    idzone     INT(11)     NOT NULL AUTO_INCREMENT,
    name       VARCHAR(50) NULL DEFAULT NULL,
    phone1     VARCHAR(25) NULL DEFAULT NULL,
    phone2     VARCHAR(25) NULL DEFAULT NULL,
    email      VARCHAR(50) NULL DEFAULT NULL,
    country    INT(11)     NULL DEFAULT NULL,
    region     INT(11)     NULL DEFAULT NULL,
    town       INT(11)     NULL DEFAULT NULL,
    address    VARCHAR(50) NULL DEFAULT NULL,
    postcode   INT(11)     NULL DEFAULT NULL,
    network    INT(11)     NULL DEFAULT NULL,
    updated_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idzone),
    FOREIGN KEY (country) REFERENCES countries (idcountry),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (region) REFERENCES regions (idregi),
    FOREIGN KEY (town) REFERENCES towns (idtown)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table institutions
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS institutions
(
    idinst     INT(11)     NOT NULL AUTO_INCREMENT,
    name       VARCHAR(50) NULL DEFAULT NULL,
    phone1     VARCHAR(25) NULL DEFAULT NULL,
    phone2     VARCHAR(25) NULL DEFAULT NULL,
    email      VARCHAR(50) NULL DEFAULT NULL,
    region     INT(11)     NULL DEFAULT NULL,
    town       INT(11)     NULL DEFAULT NULL,
    address    VARCHAR(50) NULL DEFAULT NULL,
    postcode   INT(11)     NULL DEFAULT NULL,
    zone       INT(11)     NULL DEFAULT NULL,
    updated_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idinst),
    FOREIGN KEY (region) REFERENCES regions (idregi),
    FOREIGN KEY (town) REFERENCES towns (idtown),
    FOREIGN KEY (zone) REFERENCES zones (idzone)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table branches
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS branches
(
    idbranch    INT(11)     NOT NULL AUTO_INCREMENT,
    name        VARCHAR(50) NULL DEFAULT NULL,
    phone1      VARCHAR(25) NULL DEFAULT NULL,
    phone2      VARCHAR(25) NULL DEFAULT NULL,
    email       VARCHAR(50) NULL DEFAULT NULL,
    region      INT(11)     NULL DEFAULT NULL,
    town        INT(11)     NULL DEFAULT NULL,
    address     VARCHAR(50) NULL DEFAULT NULL,
    postcode    INT(11)     NULL DEFAULT NULL,
    institution INT(11)     NULL DEFAULT NULL,
    updated_at  DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idbranch),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (region) REFERENCES regions (idregi),
    FOREIGN KEY (town) REFERENCES towns (idtown)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table divisions
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS divisions
(
    iddiv      INT(11)     NOT NULL AUTO_INCREMENT,
    label      VARCHAR(45) NULL DEFAULT NULL,
    region     INT(11)     NULL DEFAULT NULL,
    updated_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (iddiv),
    FOREIGN KEY (region) REFERENCES regions (idregi)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table sub_divs
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS sub_divs
(
    idsub      INT(11)     NOT NULL AUTO_INCREMENT,
    label      VARCHAR(45) NULL DEFAULT NULL,
    division   INT(11)     NULL DEFAULT NULL,
    updated_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idsub),
    FOREIGN KEY (division) REFERENCES divisions (iddiv)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table members
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS members
(
    idmember    INT(11)                        NOT NULL AUTO_INCREMENT,
    memnumb     VARCHAR(6)                     NULL     DEFAULT NULL,
    name        VARCHAR(50)                    NULL     DEFAULT NULL,
    surname     VARCHAR(50)                    NULL     DEFAULT NULL,
    gender      ENUM ('M', 'F')                NOT NULL DEFAULT 'M' COMMENT 'M - Male\nF - Female',
    dob         DATE                           NULL     DEFAULT NULL,
    pob         VARCHAR(50)                    NULL     DEFAULT NULL,
    phone1      VARCHAR(25)                    NULL     DEFAULT NULL,
    phone2      VARCHAR(25)                    NULL     DEFAULT NULL,
    email       VARCHAR(50)                    NULL     DEFAULT NULL,
    status      ENUM ('M', 'S', 'D', 'W', 'O') NOT NULL DEFAULT 'M' COMMENT 'M - Married\nS - Single\nD - Divorced\nW - Widow\nO - Others',
    profession  VARCHAR(50)                    NULL     DEFAULT NULL,
    nic         INT(25)                        NULL     DEFAULT NULL,
    pic         VARCHAR(255)                   NULL     DEFAULT NULL,
    signature   VARCHAR(255)                   NULL     DEFAULT NULL,
    issuedate   DATE                           NULL     DEFAULT NULL,
    issueplace  VARCHAR(50)                    NULL     DEFAULT NULL,
    cnpsnumb    INT(11)                        NULL     DEFAULT NULL,
    memtype     ENUM ('P', 'A', 'E')           NULL     DEFAULT 'P' COMMENT 'P - Physical\nA - Assocation\nE - Enterprise',
    assno       VARCHAR(50)                    NULL     DEFAULT NULL,
    asstype     VARCHAR(50)                    NULL     DEFAULT NULL,
    assmemno    INT(11)                        NULL     DEFAULT NULL,
    sign2       VARCHAR(255)                   NULL     DEFAULT NULL,
    sign3       VARCHAR(255)                   NULL     DEFAULT NULL,
    taxpaynumb  VARCHAR(25)                    NULL     DEFAULT NULL,
    comregis    VARCHAR(25)                    NULL     DEFAULT NULL,
    regime      VARCHAR(25)                    NULL     DEFAULT NULL,
    country     INT(11)                        NULL     DEFAULT NULL,
    regorigin   INT(11)                        NULL     DEFAULT NULL,
    region      INT(11)                        NULL     DEFAULT NULL,
    town        INT(11)                        NULL     DEFAULT NULL,
    division    INT(11)                        NULL     DEFAULT NULL,
    subdivision INT(11)                        NULL     DEFAULT NULL,
    address     VARCHAR(50)                    NULL     DEFAULT NULL,
    street      VARCHAR(50)                    NULL     DEFAULT NULL,
    quarter     VARCHAR(50)                    NULL     DEFAULT NULL,
    witnes_name VARCHAR(50)                    NULL     DEFAULT NULL,
    witnes_nic  INT(25)                        NULL     DEFAULT NULL,
    network     INT(11)                        NULL     DEFAULT NULL,
    zone        INT(11)                        NULL     DEFAULT NULL,
    institution INT(11)                        NULL     DEFAULT NULL,
    branch      INT(11)                        NULL     DEFAULT NULL,
    memstatus   ENUM ('A', 'D')                NOT NULL DEFAULT 'A' COMMENT 'A - Active\nD - Dead',
    updated_at  DATETIME                       NULL     DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME                       NULL     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idmember),
    FOREIGN KEY (branch) REFERENCES branches (idbranch),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (zone) REFERENCES zones (idzone),
    FOREIGN KEY (country) REFERENCES countries (idcountry),
    FOREIGN KEY (division) REFERENCES divisions (iddiv),
    FOREIGN KEY (regorigin) REFERENCES regions (idregi),
    FOREIGN KEY (region) REFERENCES regions (idregi),
    FOREIGN KEY (subdivision) REFERENCES sub_divs (idsub),
    FOREIGN KEY (town) REFERENCES towns (idtown)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table accounts
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS accounts
(
    idaccount   INT(11)        NOT NULL AUTO_INCREMENT,
    accnumb     VARCHAR(15)    NULL DEFAULT NULL,
    labelfr     TEXT           NULL DEFAULT NULL,
    labeleng    TEXT           NULL DEFAULT NULL,
    accplan     VARCHAR(10)    NULL DEFAULT NULL,
    acctype     INT(11)        NULL DEFAULT NULL,
    initamt     DECIMAL(65, 2) NULL DEFAULT NULL,
    country     INT(11)        NULL DEFAULT NULL,
    network     INT(11)        NULL DEFAULT NULL,
    zone        INT(11)        NULL DEFAULT NULL,
    institution INT(11)        NULL DEFAULT NULL,
    branch      INT(11)        NULL DEFAULT NULL,
    updated_at  DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idaccount),
    FOREIGN KEY (branch) REFERENCES branches (idbranch),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (country) REFERENCES countries (idcountry),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (zone) REFERENCES zones (idzone),
    FOREIGN KEY (acctype) REFERENCES acc_types (idacctype)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table acc_dates
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS acc_dates
(
    idaccdate   INT(11)         NOT NULL AUTO_INCREMENT,
    presentdate DATE            NULL DEFAULT NULL,
    evedate     DATE            NULL DEFAULT NULL,
    accdate     DATE            NULL DEFAULT NULL,
    monthend    DATE            NULL DEFAULT NULL,
    weekend     DATE            NULL DEFAULT NULL,
    status      ENUM ('O', 'C') NULL DEFAULT NULL COMMENT 'O - Opened\nC - Closed',
    network     INT(11)         NULL DEFAULT NULL,
    zone        INT(11)         NULL DEFAULT NULL,
    institution INT(11)         NULL DEFAULT NULL,
    branch      INT(11)         NULL DEFAULT NULL,
    updated_at  DATETIME        NULL DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME        NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idaccdate),
    FOREIGN KEY (branch) REFERENCES branches (idbranch),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (zone) REFERENCES zones (idzone),
    FOREIGN KEY (institution) REFERENCES institutions (idinst)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table banks
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS banks
(
    idbank      INT(11)     NOT NULL AUTO_INCREMENT,
    bankcode    VARCHAR(6)  NULL DEFAULT NULL,
    name        VARCHAR(50) NULL DEFAULT NULL,
    ouracc      VARCHAR(25) NULL DEFAULT NULL,
    theiracc    INT(11)     NULL DEFAULT NULL,
    checasacc   INT(11)     NULL DEFAULT NULL,
    cheaccre    INT(11)     NULL DEFAULT NULL,
    corecacc    INT(11)     NULL DEFAULT NULL,
    phone1      VARCHAR(25) NULL DEFAULT NULL,
    phone2      VARCHAR(25) NULL DEFAULT NULL,
    email       VARCHAR(50) NULL DEFAULT NULL,
    country     INT(11)     NULL DEFAULT NULL,
    region      INT(11)     NULL DEFAULT NULL,
    division    INT(11)     NULL DEFAULT NULL,
    subdivision INT(11)     NULL DEFAULT NULL,
    town        INT(11)     NULL DEFAULT NULL,
    address     VARCHAR(50) NULL DEFAULT NULL,
    postcode    INT(11)     NULL DEFAULT NULL,
    institution INT(11)     NULL DEFAULT NULL,
    branch      INT(11)     NULL DEFAULT NULL,
    member      INT(11)     NULL DEFAULT NULL,
    updated_at  DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idbank),
    FOREIGN KEY (branch) REFERENCES branches (idbranch),
    FOREIGN KEY (country) REFERENCES countries (idcountry),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (region) REFERENCES regions (idregi),
    FOREIGN KEY (division) REFERENCES divisions (iddiv),
    FOREIGN KEY (subdivision) REFERENCES sub_divs (idsub),
    FOREIGN KEY (town) REFERENCES towns (idtown),
    FOREIGN KEY (member) REFERENCES members (idmember),
    FOREIGN KEY (theiracc) REFERENCES accounts (idaccount),
    FOREIGN KEY (checasacc) REFERENCES accounts (idaccount),
    FOREIGN KEY (cheaccre) REFERENCES accounts (idaccount),
    FOREIGN KEY (corecacc) REFERENCES accounts (idaccount)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table benefs
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS benefs
(
    idbene     INT(11)     NOT NULL AUTO_INCREMENT,
    fullname   VARCHAR(50) NULL DEFAULT NULL,
    nic        INT(25)     NULL DEFAULT NULL,
    relation   VARCHAR(25) NULL DEFAULT NULL,
    member     INT(11)     NULL DEFAULT NULL,
    ratio      INT(3)      NULL DEFAULT NULL,
    created_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idbene),
    FOREIGN KEY (member) REFERENCES members (idmember)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table moneys
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS moneys
(
    idmoney    INT(11)         NOT NULL AUTO_INCREMENT,
    moncode    VARCHAR(5)      NULL DEFAULT NULL,
    value      INT(11)         NULL DEFAULT NULL,
    format     ENUM ('B', 'C') NOT NULL COMMENT 'B - Bank Note\nC - Coin',
    labeleng   VARCHAR(25)     NULL DEFAULT NULL,
    labelfr    VARCHAR(25)     NULL DEFAULT NULL,
    currency   INT(11)         NULL DEFAULT NULL,
    updated_at DATETIME        NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME        NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idmoney),
    FOREIGN KEY (currency) REFERENCES currencies (idcurrency)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table budgets
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS budgets
(
    idbudget    INT(11)        NOT NULL AUTO_INCREMENT,
    account     INT(11)        NULL DEFAULT NULL,
    budgetline  INT(11)        NULL DEFAULT NULL,
    mode        VARCHAR(10)    NULL DEFAULT NULL,
    budm1       DECIMAL(65, 2) NULL DEFAULT NULL,
    budm2       DECIMAL(65, 2) NULL DEFAULT NULL,
    budm3       DECIMAL(65, 2) NULL DEFAULT NULL,
    budm4       DECIMAL(65, 2) NULL DEFAULT NULL,
    budm5       DECIMAL(65, 2) NULL DEFAULT NULL,
    budm6       DECIMAL(65, 2) NULL DEFAULT NULL,
    budm7       DECIMAL(65, 2) NULL DEFAULT NULL,
    budm8       DECIMAL(65, 2) NULL DEFAULT NULL,
    budm9       DECIMAL(65, 2) NULL DEFAULT NULL,
    budm10      DECIMAL(65, 2) NULL DEFAULT NULL,
    budm11      DECIMAL(65, 2) NULL DEFAULT NULL,
    budm12      DECIMAL(65, 2) NULL DEFAULT NULL,
    totamt      DECIMAL(65, 2) NULL DEFAULT NULL,
    budgetype1  VARCHAR(25)    NULL DEFAULT NULL,
    budgetype2  VARCHAR(25)    NULL DEFAULT NULL,
    institution INT(11)        NULL DEFAULT NULL,
    branch      INT(11)        NULL DEFAULT NULL,
    updated_at  DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idbudget),
    FOREIGN KEY (branch) REFERENCES branches (idbranch),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (account) REFERENCES accounts (idaccount)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table privileges
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS privileges
(
    idpriv     INT(11)                             NOT NULL AUTO_INCREMENT,
    labeleng   VARCHAR(45)                         NULL DEFAULT NULL,
    labelfr    VARCHAR(45)                         NULL DEFAULT NULL,
    level      ENUM ('A', 'O', 'N', 'Z', 'I', 'B') NOT NULL COMMENT 'A - Administrator\nO - Organ\nN - Network\nI - Institution\nB - Branch',
    updated_at DATETIME                            NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME                            NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idpriv)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table emprofs
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS employees
(
    idemp       INT(11)                        NOT NULL AUTO_INCREMENT,
    empmat      VARCHAR(25)                    NULL     DEFAULT NULL,
    name        VARCHAR(50)                    NULL     DEFAULT NULL,
    surname     VARCHAR(50)                    NULL     DEFAULT NULL,
    gender      ENUM ('M', 'F')                NOT NULL DEFAULT 'M' COMMENT 'M - Male\nF - Female',
    dob         DATE                           NULL     DEFAULT NULL,
    pob         VARCHAR(50)                    NULL     DEFAULT NULL,
    phone1      VARCHAR(25)                    NULL     DEFAULT NULL,
    phone2      VARCHAR(25)                    NULL     DEFAULT NULL,
    email       VARCHAR(50)                    NULL     DEFAULT NULL,
    status      ENUM ('M', 'S', 'D', 'W', 'O') NULL     DEFAULT 'M' COMMENT 'M - Married\nS - Single\nD - Divorced\nW - Widow\nO - Others',
    nic         INT(25)                        NULL     DEFAULT NULL,
    issuedate   DATE                           NULL     DEFAULT NULL,
    issueplace  VARCHAR(50)                    NULL     DEFAULT NULL,
    cnpsnumb    INT(11)                        NULL     DEFAULT NULL,
    pic         VARCHAR(255)                   NULL     DEFAULT NULL,
    signature   VARCHAR(255)                   NULL     DEFAULT NULL,
    country     INT(11)                        NULL     DEFAULT NULL,
    regorigin   INT(11)                        NULL     DEFAULT NULL,
    region      INT(11)                        NULL     DEFAULT NULL,
    town        INT(11)                        NULL     DEFAULT NULL,
    division    INT(11)                        NULL     DEFAULT NULL,
    subdivision INT(11)                        NULL     DEFAULT NULL,
    address     VARCHAR(50)                    NULL     DEFAULT NULL,
    street      VARCHAR(50)                    NULL     DEFAULT NULL,
    quarter     VARCHAR(50)                    NULL     DEFAULT NULL,
    post        VARCHAR(50)                    NULL     DEFAULT NULL,
    password    VARCHAR(255)                   NULL     DEFAULT NULL,
    empdate     DATE                           NULL     DEFAULT NULL,
    network     INT(11)                        NULL     DEFAULT NULL,
    zone        INT(11)                        NULL     DEFAULT NULL,
    institution INT(11)                        NULL     DEFAULT NULL,
    branch      INT(11)                        NULL     DEFAULT NULL,
    privilege   INT(11)                        NULL     DEFAULT NULL,
    updated_at  DATETIME                       NULL     DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME                       NULL     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idemp),
    FOREIGN KEY (country) REFERENCES countries (idcountry),
    FOREIGN KEY (division) REFERENCES divisions (iddiv),
    FOREIGN KEY (privilege) REFERENCES privileges (idpriv),
    FOREIGN KEY (regorigin) REFERENCES regions (idregi),
    FOREIGN KEY (region) REFERENCES regions (idregi),
    FOREIGN KEY (subdivision) REFERENCES sub_divs (idsub),
    FOREIGN KEY (town) REFERENCES towns (idtown),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (zone) REFERENCES zones (idzone),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (branch) REFERENCES branches (idbranch)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table cashes
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS cashes
(
    idcash      INT(11)              NOT NULL AUTO_INCREMENT,
    cashcode    VARCHAR(6)           NULL     DEFAULT NULL,
    labelfr     VARCHAR(50)          NULL     DEFAULT NULL,
    labeleng    VARCHAR(50)          NULL     DEFAULT NULL,
    cashacc     INT(11)              NULL     DEFAULT NULL,
    misacc      INT(11)              NULL     DEFAULT NULL,
    excacc      INT(11)              NULL     DEFAULT NULL,
    status      ENUM ('O', 'C', 'R') NOT NULL DEFAULT 'O' COMMENT 'O - Opened\nC - Closed\nR - Reopened',
    employee    INT(11)              NULL     DEFAULT NULL,
    network     INT(11)              NULL     DEFAULT NULL,
    zone        INT(11)              NULL     DEFAULT NULL,
    institution INT(11)              NULL     DEFAULT NULL,
    branch      INT(11)              NULL     DEFAULT NULL,
    mon1        INT(11)              NULL     DEFAULT NULL,
    mon2        INT(11)              NULL     DEFAULT NULL,
    mon3        INT(11)              NULL     DEFAULT NULL,
    mon4        INT(11)              NULL     DEFAULT NULL,
    mon5        INT(11)              NULL     DEFAULT NULL,
    mon6        INT(11)              NULL     DEFAULT NULL,
    mon7        INT(11)              NULL     DEFAULT NULL,
    mon8        INT(11)              NULL     DEFAULT NULL,
    mon9        INT(11)              NULL     DEFAULT NULL,
    mon10       INT(11)              NULL     DEFAULT NULL,
    mon11       INT(11)              NULL     DEFAULT NULL,
    mon12       INT(11)              NULL     DEFAULT NULL,
    closed_at   DATE                 NULL     DEFAULT NULL,
    updated_at  DATETIME             NULL     DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME             NULL     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idcash),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (zone) REFERENCES zones (idzone),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (branch) REFERENCES branches (idbranch),
    FOREIGN KEY (employee) REFERENCES employees (idemp),
    FOREIGN KEY (cashacc) REFERENCES accounts (idaccount),
    FOREIGN KEY (misacc) REFERENCES accounts (idaccount),
    FOREIGN KEY (excacc) REFERENCES accounts (idaccount)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table checks
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS checks
(
    idcheck     INT(11)        NOT NULL AUTO_INCREMENT,
    checknumb   VARCHAR(6)     NULL DEFAULT NULL,
    bank        INT(11)        NULL DEFAULT NULL,
    status      TINYINT(1)     NULL DEFAULT '0',
    amount      DECIMAL(65, 2) NULL DEFAULT NULL,
    carrier     VARCHAR(50)    NULL DEFAULT NULL,
    network     INT(11)        NULL DEFAULT NULL,
    zone        INT(11)        NULL DEFAULT NULL,
    institution INT(11)        NULL DEFAULT NULL,
    branch      INT(11)        NULL DEFAULT NULL,
    member      INT(11)        NULL DEFAULT NULL,
    updated_at  DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idcheck),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (zone) REFERENCES zones (idzone),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (branch) REFERENCES branches (idbranch),
    FOREIGN KEY (bank) REFERENCES banks (idbank),
    FOREIGN KEY (member) REFERENCES members (idmember)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table check_acc_amts
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS check_acc_amts
(
    idcheckamt INT(11)        NOT NULL AUTO_INCREMENT,
    checkno    INT(11)        NULL DEFAULT NULL,
    account    INT(11)        NULL DEFAULT NULL,
    operation  INT(11)        NULL DEFAULT NULL,
    accamt     DECIMAL(65, 2) NULL DEFAULT NULL,
    updated_at DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idcheckamt),
    FOREIGN KEY (checkno) REFERENCES checks (idcheck),
    FOREIGN KEY (operation) REFERENCES operations (idoper),
    FOREIGN KEY (account) REFERENCES accounts (idaccount)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table loan_purs
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS loan_purs
(
    idloanpur  INT(11)     NOT NULL AUTO_INCREMENT,
    labeleng   VARCHAR(50) NULL DEFAULT NULL,
    labelfr    VARCHAR(50) NULL DEFAULT NULL,
    updated_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idloanpur)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table loan_types
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS loan_types
(
    idltype      INT(11)               NOT NULL AUTO_INCREMENT,
    ltnumb       VARCHAR(6)            NULL     DEFAULT NULL,
    labeleng     VARCHAR(50)           NULL     DEFAULT NULL,
    labelfr      VARCHAR(50)           NULL     DEFAULT NULL,
    period       VARCHAR(45)           NULL     DEFAULT NULL,
    maxdur       INT(11)               NULL     DEFAULT NULL,
    maxamt       INT(25)               NULL     DEFAULT NULL,
    datescapepen INT(11)               NULL     DEFAULT NULL,
    intacc       INT(11)               NULL     DEFAULT NULL,
    loanaccart   INT(10)               NULL     DEFAULT NULL,
    getcomaker   ENUM ('Y', 'N')       NOT NULL DEFAULT 'N' COMMENT 'Y - Yes\nN - No',
    blockacc     ENUM ('M', 'Mc', 'N') NOT NULL DEFAULT 'N' COMMENT 'M - Member\nMc - Member and Co Makers\nN - None',
    paytax       ENUM ('Y', 'N')       NOT NULL DEFAULT 'N' COMMENT 'Y - Yes\nN - No',
    taxrate      DECIMAL(3, 2)         NULL     DEFAULT NULL,
    taxacc       INT(11)               NULL     DEFAULT NULL,
    usequote     ENUM ('Y', 'N')       NOT NULL DEFAULT 'N' COMMENT 'Y - Yes\nN - No',
    quoterate    DECIMAL(3, 2)         NULL     DEFAULT NULL,
    quoteaccplan INT(10)               NULL     DEFAULT NULL,
    penreq       ENUM ('Y', 'N')       NOT NULL DEFAULT 'N' COMMENT 'Y - Yes\nN - No',
    pentax       DECIMAL(3, 2)         NULL     DEFAULT NULL,
    penacc       INT(11)               NULL     DEFAULT NULL,
    network      INT(11)               NULL     DEFAULT NULL,
    zone         INT(11)               NULL     DEFAULT NULL,
    institution  INT(11)               NULL     DEFAULT NULL,
    branch       INT(11)               NULL     DEFAULT NULL,
    updated_at   DATETIME              NULL     DEFAULT CURRENT_TIMESTAMP,
    created_at   DATETIME              NULL     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idltype),
    FOREIGN KEY (intacc) REFERENCES accounts (idaccount),
    FOREIGN KEY (loanaccart) REFERENCES accounts (idaccount),
    FOREIGN KEY (taxacc) REFERENCES accounts (idaccount),
    FOREIGN KEY (penacc) REFERENCES accounts (idaccount),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (zone) REFERENCES zones (idzone),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (branch) REFERENCES branches (idbranch)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table loans
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS loans
(
    idloan      INT(11)                     NOT NULL AUTO_INCREMENT,
    member      INT(11)                     NULL     DEFAULT NULL,
    memacc      INT(11)                     NULL     DEFAULT NULL,
    transacc    INT(11)                     NULL     DEFAULT NULL,
    amount      DECIMAL(65, 2)              NULL     DEFAULT NULL,
    intrate     INT(2)                      NULL     DEFAULT NULL,
    nbrinst     INT(11)                     NULL     DEFAULT NULL,
    demdate     DATE                        NULL     DEFAULT NULL,
    appdate     DATE                        NULL     DEFAULT NULL,
    amortype    VARCHAR(50)                 NULL     DEFAULT NULL,
    period      VARCHAR(25)                 NULL     DEFAULT NULL,
    remamt      DECIMAL(65, 2)              NULL     DEFAULT NULL,
    annuity     INT(11)                     NULL     DEFAULT NULL,
    year        YEAR(4)                     NULL     DEFAULT NULL,
    vat         DECIMAL(3, 2)               NULL     DEFAULT NULL,
    instdate1   DATE                        NULL     DEFAULT NULL,
    loanpur     INT(11)                     NULL     DEFAULT NULL,
    loantype    INT(11)                     NULL     DEFAULT NULL,
    employee    INT(11)                     NULL     DEFAULT NULL,
    loanstat    ENUM ('Al', 'Ar', 'D', 'C') NOT NULL DEFAULT 'Al' COMMENT 'Al - Applied\nAr - Approved\nD - Disbursed\nC - Closed',
    status      ENUM ('N', 'Rf', 'Rs')      NOT NULL DEFAULT 'N' COMMENT 'N -  Normal\nRf - Refinanced\nRs - Restructured',
    network     INT(11)                     NULL     DEFAULT NULL,
    zone        INT(11)                     NULL     DEFAULT NULL,
    institution INT(11)                     NULL     DEFAULT NULL,
    branch      INT(11)                     NULL     DEFAULT NULL,
    updated_at  DATETIME                    NULL     DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME                    NULL     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idloan),
    FOREIGN KEY (employee) REFERENCES employees (idemp),
    FOREIGN KEY (loanpur) REFERENCES loan_purs (idloanpur),
    FOREIGN KEY (member) REFERENCES members (idmember),
    FOREIGN KEY (loanpur) REFERENCES loan_purs (idloanpur),
    FOREIGN KEY (loantype) REFERENCES loan_types (idltype),
    FOREIGN KEY (memacc) REFERENCES accounts (idaccount),
    FOREIGN KEY (transacc) REFERENCES accounts (idaccount),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (zone) REFERENCES zones (idzone),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (branch) REFERENCES branches (idbranch)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table comakers
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS comakers
(
    idcomaker  INT(11)       NOT NULL AUTO_INCREMENT,
    loan       INT(11)       NULL DEFAULT NULL,
    member     INT(11)       NULL DEFAULT NULL,
    gaurtype   VARCHAR(50)   NULL DEFAULT NULL,
    gauramt    DECIMAL(3, 2) NULL DEFAULT NULL,
    updated_at DATETIME      NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME      NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idcomaker),
    FOREIGN KEY (loan) REFERENCES loans (idloan),
    FOREIGN KEY (member) REFERENCES members (idmember)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table directors
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS directors
(
    iddirect   INT(10)     NOT NULL AUTO_INCREMENT,
    elecdate   DATE        NULL DEFAULT NULL,
    functions  VARCHAR(45) NULL DEFAULT NULL,
    man_dur    VARCHAR(45) NULL DEFAULT NULL,
    employee   INT(11)     NULL DEFAULT NULL,
    network    INT(11)     NULL DEFAULT NULL,
    updated_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (iddirect),
    FOREIGN KEY (employee) REFERENCES employees (idemp),
    FOREIGN KEY (network) REFERENCES networks (idnetwork)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table immos
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS immos
(
    idimmo      INT(11)        NOT NULL AUTO_INCREMENT,
    acqdate     DATE           NULL DEFAULT NULL,
    value       INT(11)        NULL DEFAULT NULL,
    duration    VARCHAR(10)    NULL DEFAULT NULL,
    amordate    DATE           NULL DEFAULT NULL,
    resivalue   INT(11)        NULL DEFAULT NULL,
    amoramt     DECIMAL(65, 2) NULL DEFAULT NULL,
    disposamt   DECIMAL(65, 2) NULL DEFAULT NULL,
    network     INT(11)        NULL DEFAULT NULL,
    zone        INT(11)        NULL DEFAULT NULL,
    institution INT(11)        NULL DEFAULT NULL,
    branch      INT(11)        NULL DEFAULT NULL,
    updated_at  DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idimmo),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (zone) REFERENCES zones (idzone),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (branch) REFERENCES branches (idbranch)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table operations
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS operations
(
    idoper      INT(11)     NOT NULL AUTO_INCREMENT,
    opercode    INT(11)     NULL DEFAULT NULL,
    labelfr     VARCHAR(50) NULL DEFAULT NULL,
    labeleng    VARCHAR(50) NULL DEFAULT NULL,
    debitfr     VARCHAR(50) NULL DEFAULT NULL,
    debiteng    VARCHAR(50) NULL DEFAULT NULL,
    creditfr    VARCHAR(50) NULL DEFAULT NULL,
    crediteng   VARCHAR(50) NULL DEFAULT NULL,
    institution INT(11)     NULL DEFAULT NULL,
    branch      INT(11)     NULL DEFAULT NULL,
    updated_at  DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idoper),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (branch) REFERENCES branches (idbranch)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table registers
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS registers
(
    idregister  INT(11)                        NOT NULL AUTO_INCREMENT,
    regnumb     VARCHAR(6)                     NULL     DEFAULT NULL,
    name        VARCHAR(50)                    NULL     DEFAULT NULL,
    surname     VARCHAR(50)                    NULL     DEFAULT NULL,
    gender      ENUM ('M', 'F')                NOT NULL DEFAULT 'M' COMMENT 'M - Male \nF - Female',
    dob         DATE                           NULL     DEFAULT NULL,
    pob         VARCHAR(50)                    NULL     DEFAULT NULL,
    phone1      VARCHAR(25)                    NULL     DEFAULT NULL,
    phone2      VARCHAR(25)                    NULL     DEFAULT NULL,
    email       VARCHAR(50)                    NULL     DEFAULT NULL,
    status      ENUM ('M', 'S', 'D', 'W', 'O') NOT NULL DEFAULT 'M' COMMENT 'M - Married\nS - Single\nD -  Divorced\nW - Widow\nO - Others',
    profession  VARCHAR(50)                    NULL     DEFAULT NULL,
    nic         INT(25)                        NULL     DEFAULT NULL,
    pic         VARCHAR(255)                   NULL     DEFAULT NULL,
    signature   VARCHAR(255)                   NULL     DEFAULT NULL,
    issuedate   DATE                           NULL     DEFAULT NULL,
    issueplace  VARCHAR(50)                    NULL     DEFAULT NULL,
    cnpsnumb    INT(11)                        NULL     DEFAULT NULL,
    memtype     ENUM ('P', 'A', 'E')           NOT NULL DEFAULT 'P' COMMENT 'P - Physical\nA - Assocation\nE - Enterprise',
    assno       VARCHAR(50)                    NULL     DEFAULT NULL,
    asstype     VARCHAR(50)                    NULL     DEFAULT NULL,
    assmemno    INT(11)                        NULL     DEFAULT NULL,
    sign2       VARCHAR(255)                   NULL     DEFAULT NULL,
    sign3       VARCHAR(255)                   NULL     DEFAULT NULL,
    taxpaynumb  VARCHAR(25)                    NULL     DEFAULT NULL,
    comregis    VARCHAR(25)                    NULL     DEFAULT NULL,
    regime      VARCHAR(25)                    NULL     DEFAULT NULL,
    country     INT(11)                        NULL     DEFAULT NULL,
    regorigin   INT(11)                        NULL     DEFAULT NULL,
    region      INT(11)                        NULL     DEFAULT NULL,
    town        INT(11)                        NULL     DEFAULT NULL,
    division    INT(11)                        NULL     DEFAULT NULL,
    subdivision INT(11)                        NULL     DEFAULT NULL,
    address     VARCHAR(50)                    NULL     DEFAULT NULL,
    street      VARCHAR(50)                    NULL     DEFAULT NULL,
    quarter     VARCHAR(50)                    NULL     DEFAULT NULL,
    witnes_name VARCHAR(50)                    NULL     DEFAULT NULL,
    witnes_nic  INT(25)                        NULL     DEFAULT NULL,
    network     INT(11)                        NULL     DEFAULT NULL,
    zone        INT(11)                        NULL     DEFAULT NULL,
    institution INT(11)                        NULL     DEFAULT NULL,
    branch      INT(11)                        NULL     DEFAULT NULL,
    regstatus   ENUM ('R', 'D')                NOT NULL DEFAULT 'R' COMMENT 'R - Register\nD - Denied',
    updated_at  DATETIME                       NULL     DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME                       NULL     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idregister),
    FOREIGN KEY (branch) REFERENCES branches (idbranch),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (zone) REFERENCES zones (idzone),
    FOREIGN KEY (country) REFERENCES countries (idcountry),
    FOREIGN KEY (division) REFERENCES divisions (iddiv),
    FOREIGN KEY (regorigin) REFERENCES regions (idregi),
    FOREIGN KEY (region) REFERENCES regions (idregi),
    FOREIGN KEY (subdivision) REFERENCES sub_divs (idsub),
    FOREIGN KEY (town) REFERENCES towns (idtown)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table reg_beneficiaries
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS reg_benefs
(
    idregbene  INT(11)     NOT NULL AUTO_INCREMENT,
    fullname   VARCHAR(50) NULL DEFAULT NULL,
    nic        INT(25)     NULL DEFAULT NULL,
    relation   VARCHAR(25) NULL DEFAULT NULL,
    register   INT(11)     NULL DEFAULT NULL,
    ratio      INT(3)      NULL DEFAULT NULL,
    created_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME    NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idregbene),
    FOREIGN KEY (register) REFERENCES registers (idregister)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table writings
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS writings
(
    idwrit      INT(11)        NOT NULL AUTO_INCREMENT,
    writnumb    INT(20)        NULL DEFAULT NULL,
    account     INT(11)        NULL DEFAULT NULL,
    aux         INT(11)        NULL,
    operation   INT(11)        NULL DEFAULT NULL,
    debitamt    DECIMAL(65, 2) NULL DEFAULT NULL,
    creditamt   DECIMAL(65, 2) NULL DEFAULT NULL,
    accdate     INT(11)        NULL DEFAULT NULL,
    employee    INT(11)        NULL DEFAULT NULL,
    cash        INT(11)        NULL DEFAULT NULL,
    network     INT(11)        NULL DEFAULT NULL,
    zone        INT(11)        NULL DEFAULT NULL,
    institution INT(11)        NULL DEFAULT NULL,
    branch      INT(11)        NULL DEFAULT NULL,
    represent   VARCHAR(50)    NULL DEFAULT NULL,
    updated_at  DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idwrit),
    FOREIGN KEY (accdate) REFERENCES acc_dates (idaccdate),
    FOREIGN KEY (branch) REFERENCES branches (idbranch),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (zone) REFERENCES zones (idzone),
    FOREIGN KEY (operation) REFERENCES operations (idoper),
    FOREIGN KEY (account) REFERENCES accounts (idaccount),
    FOREIGN KEY (employee) REFERENCES employees (idemp),
    FOREIGN KEY (cash) REFERENCES cashes (idcash)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table mem_settings
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS mem_settings
(
    idmemset    INT(11)         NOT NULL AUTO_INCREMENT,
    account     INT(11)         NULL DEFAULT NULL,
    operation   INT(11)         NULL DEFAULT NULL,
    amount      DECIMAL(65, 2)  NULL DEFAULT NULL,
    type        ENUM ('C', 'G') NULL DEFAULT NULL,
    institution INT(11)         NULL DEFAULT NULL,
    branch      INT(11)         NULL DEFAULT NULL,
    created_at  DATETIME        NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME        NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idmemset),
    FOREIGN KEY (account) REFERENCES accounts (idaccount),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (branch) REFERENCES branches (idbranch),
    FOREIGN KEY (operation) REFERENCES operations (idoper)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table val_writings
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS val_writings
(
    idvalwrit   INT(11)        NOT NULL AUTO_INCREMENT,
    writnumb    INT(20)        NULL DEFAULT NULL,
    account     INT(11)        NULL DEFAULT NULL,
    aux         INT(11)        NULL,
    operation   INT(11)        NULL DEFAULT NULL,
    debitamt    DECIMAL(65, 2) NULL DEFAULT NULL,
    creditamt   DECIMAL(65, 2) NULL DEFAULT NULL,
    accdate     INT(11)        NULL DEFAULT NULL,
    employee    INT(11)        NULL DEFAULT NULL,
    cash        INT(11)        NULL DEFAULT NULL,
    network     INT(11)        NULL DEFAULT NULL,
    zone        INT(11)        NULL DEFAULT NULL,
    institution INT(11)        NULL DEFAULT NULL,
    branch      INT(11)        NULL DEFAULT NULL,
    represent   VARCHAR(50)    NULL DEFAULT NULL,
    updated_at  DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idvalwrit),
    FOREIGN KEY (accdate) REFERENCES acc_dates (idaccdate),
    FOREIGN KEY (branch) REFERENCES branches (idbranch),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (zone) REFERENCES zones (idzone),
    FOREIGN KEY (operation) REFERENCES operations (idoper),
    FOREIGN KEY (account) REFERENCES accounts (idaccount),
    FOREIGN KEY (employee) REFERENCES employees (idemp),
    FOREIGN KEY (cash) REFERENCES cashes (idcash)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table collectors
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS collectors
(
    idcoll      INT(11)                        NOT NULL AUTO_INCREMENT,
    colmat      VARCHAR(25)                    NULL     DEFAULT NULL,
    name        VARCHAR(50)                    NULL     DEFAULT NULL,
    surname     VARCHAR(50)                    NULL     DEFAULT NULL,
    gender      ENUM ('M', 'F')                NOT NULL DEFAULT 'M' COMMENT 'M - Male\nF - Female',
    dob         DATE                           NULL     DEFAULT NULL,
    pob         VARCHAR(50)                    NULL     DEFAULT NULL,
    phone1      VARCHAR(25)                    NULL     DEFAULT NULL,
    phone2      VARCHAR(25)                    NULL     DEFAULT NULL,
    email       VARCHAR(50)                    NULL     DEFAULT NULL,
    status      ENUM ('M', 'S', 'D', 'W', 'O') NULL     DEFAULT 'M' COMMENT 'M - Married\nS - Single\nD - Divorced\nW - Widow\nO - Others',
    nic         INT(25)                        NULL     DEFAULT NULL,
    issuedate   DATE                           NULL     DEFAULT NULL,
    issueplace  VARCHAR(50)                    NULL     DEFAULT NULL,
    cnpsnumb    INT(11)                        NULL     DEFAULT NULL,
    pic         VARCHAR(255)                   NULL     DEFAULT NULL,
    signature   VARCHAR(255)                   NULL     DEFAULT NULL,
    country     INT(11)                        NULL     DEFAULT NULL,
    regorigin   INT(11)                        NULL     DEFAULT NULL,
    region      INT(11)                        NULL     DEFAULT NULL,
    town        INT(11)                        NULL     DEFAULT NULL,
    division    INT(11)                        NULL     DEFAULT NULL,
    subdivision INT(11)                        NULL     DEFAULT NULL,
    address     VARCHAR(50)                    NULL     DEFAULT NULL,
    street      VARCHAR(50)                    NULL     DEFAULT NULL,
    quarter     VARCHAR(50)                    NULL     DEFAULT NULL,
    post        VARCHAR(50)                    NULL     DEFAULT NULL,
    password    VARCHAR(255)                   NULL     DEFAULT NULL,
    empdate     DATE                           NULL     DEFAULT NULL,
    network     INT(11)                        NULL     DEFAULT NULL,
    zone        INT(11)                        NULL     DEFAULT NULL,
    institution INT(11)                        NULL     DEFAULT NULL,
    branch      INT(11)                        NULL     DEFAULT NULL,
    privilege   INT(11)                        NULL     DEFAULT NULL,
    updated_at  DATETIME                       NULL     DEFAULT CURRENT_TIMESTAMP,
    created_at  DATETIME                       NULL     DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idcoll),
    FOREIGN KEY (network) REFERENCES networks (idnetwork),
    FOREIGN KEY (zone) REFERENCES zones (idzone),
    FOREIGN KEY (institution) REFERENCES institutions (idinst),
    FOREIGN KEY (branch) REFERENCES branches (idbranch),
    FOREIGN KEY (country) REFERENCES countries (idcountry),
    FOREIGN KEY (division) REFERENCES divisions (iddiv),
    FOREIGN KEY (privilege) REFERENCES privileges (idpriv),
    FOREIGN KEY (regorigin) REFERENCES regions (idregi),
    FOREIGN KEY (region) REFERENCES regions (idregi),
    FOREIGN KEY (subdivision) REFERENCES sub_divs (idsub),
    FOREIGN KEY (town) REFERENCES towns (idtown)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table balances
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS balances
(
    idbal      INT(11)        NOT NULL AUTO_INCREMENT,
    member     INT(11)        NULL DEFAULT NULL,
    account    INT(11)        NULL DEFAULT NULL,
    initbal    DECIMAL(65, 2) NULL DEFAULT NULL,
    evebal     DECIMAL(65, 2) NULL DEFAULT NULL,
    available  DECIMAL(65, 2) NULL DEFAULT NULL,
    created_at DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME       NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idbal),
    FOREIGN KEY (account) REFERENCES accounts (idaccount),
    FOREIGN KEY (member) REFERENCES members (idmember)
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;

SET SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;
