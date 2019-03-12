alter table `Login`
change column `UserId` `UserId` VARCHAR(255) NOT NULL;
alter table `Ticket`
change column `UserId` `UserId` VARCHAR(255) NOT NULL;
alter table `Comment`
change column `UserId` `UserId` VARCHAR(255) NOT NULL;
SET FOREIGN_KEY_CHECKS = 1;

CREATE table Login(
    UserID VARCHAR(255) not null,
    PW VARCHAR(255) not null,
    PRIMARY KEY(UserId)
) ENGINE = INNODB;

CREATE table Ticket(
    TicketId INT not null,
    SeatNo VARCHAR(255) not null,
    BroadCastId INT not null,
    Valid VARChAR(255),
    UserId VARCHAR(255),
    TicketType VARCHAR(255),
    TicketFee VARCHAR(255),
    PRIMARY KEY(TicketId),
    FOREIGN KEY(BroadCastId) REFERENCES BroadCast(BroadCastId),
    FOREIGN KEY(UserId) REFERENCES Login(UserId)
) ENGINE = INNODB;

CREATE TABLE Comment(
    CommentId INT PRIMARY KEY,
    FilmId INT,
    UserId VARCHAR(255),
    Comment Text,
    FOREIGN KEY (FilmId) REFERENCES Film(FilmId),
    FOREIGN KEY (UserId) REFERENCES Login(UserId)
) ENGINE = INNODB;

INSERT INTO `BroadCast` (`BroadCastId`, `Dates`, `Time`, `FilmId`, `HouseId`, `day`) VALUES ('1', ': 16/11/2015', '12:10', '1', 'House A', 'Mon'), ('2', '16/11/2015', '13:10', '1', 'House C', 'Mon')