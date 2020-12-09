UPDATE `ProductsMeasures` SET `value` = '100.12' WHERE `ProductsMeasures`.`prodId` = 1 AND `ProductsMeasures`.`size_name` = 'l';
UPDATE `ProductsMeasures` SET `value` = '80.12' WHERE `ProductsMeasures`.`prodId` = 1 AND `ProductsMeasures`.`size_name` = 'm';
UPDATE `ProductsMeasures` SET `value` = '60.12' WHERE `ProductsMeasures`.`prodId` = 1 AND `ProductsMeasures`.`size_name` = 's';

DELETE FROM `Orders-BoxProducts`;
DELETE FROM `Orders`;
DELETE FROM `EmailsSent`;
UPDATE `Products-Sizes` SET `stock` = '5' WHERE `Products-Sizes`.`prodId` = 1 OR `Products-Sizes`.`prodId` = 2;
UPDATE `DiscountCodes` SET `nbUse` = '1' WHERE `DiscountCodes`.`discountCode` = 'free_shipping_be';
UPDATE `DiscountCodes` SET `nbUse` = '0' WHERE `DiscountCodes`.`discountCode` = 'free_shipping_ca';
UPDATE `DiscountCodes` SET `nbUse` = '-1' WHERE `DiscountCodes`.`discountCode` = 'summer20';
UPDATE `DiscountCodes` SET `nbUse` = NULL WHERE `DiscountCodes`.`discountCode` = 'winter30';

DELETE FROM `Orders-BoxProducts`;
DELETE FROM `Orders-Boxes`;
UPDATE `Products-Sizes` SET `stock` = '5' WHERE `Products-Sizes`.`prodId` = 1;





SELECT *
FROM `Users-Cookies`
WHERE `cookieId`='VIS' AND `userId` NOT IN (SELECT `userId`
							   				FROM `Users-Cookies`
							   				WHERE `cookieId`='ADM' OR `cookieId`='CLT');

DELETE FROM `Users-Cookies`
WHERE `cookieId`='VIS' AND `userId` IN (SELECT `userID` FROM `Users` WHERE `mail` IS NULL) ORDER BY `userId` ASC;
DELETE FROM `Users` WHERE `mail` IS NULL;

CONSTRAINT `fk-userId.Locations-FROM-`

CREATE TABLE Locations (
	`userId` INTEGER(11) NOT NULL,
	`nav_date` DATETIME NOT NULL,
	`locationDate` DATETIME NOT NULL,
	`status` VARCHAR(20) NOT NULL,
	`message` VARCHAR(100) NOT NULL,
	`continent` VARCHAR(50) NOT NULL,
	`continentCode` VARCHAR(10) NOT NULL,
	`country` VARCHAR(50) NOT NULL,
	`countryCode` VARCHAR(10) NOT NULL,
	`region` VARCHAR(10) NOT NULL,
	`regionName` VARCHAR(100) NOT NULL,
	`city` VARCHAR(100) NOT NULL,
	`district` VARCHAR(100) NOT NULL,
	`zip` VARCHAR(50) NOT NULL,
	`lat` FLOAT NOT NULL,
	`lon` FLOAT NOT NULL,
	`timezone` VARCHAR(50) NOT NULL,
	`offset` FLOAT NOT NULL,
	`currency` VARCHAR(50) NOT NULL,
	`isp` VARCHAR(100) NOT NULL,
	`org` VARCHAR(100) NOT NULL,
	`as` VARCHAR(100) NOT NULL,
	`asname` VARCHAR(100) NOT NULL,
	`reverse` VARCHAR(100) NOT NULL,
	`mobile` BOOLEAN NOT NULL,
	`proxy` BOOLEAN NOT NULL,
	`hosting` BOOLEAN NOT NULL,
	`query` VARCHAR(100) NOT NULL
);

            status          success or fail
            message         included only when status is fail Can be one of the following: private range, reserved range, invalid query
            continent       Continent name
            continentCode   Two-letter continent code
            country         Country name
            countryCode     Two-letter country code ISO 3166-1 alpha-2
            region          Region/state short code (FIPS or ISO)
            regionName      Region/state
            city            City
            district        District (subdivision of city)
            zip             Zip code
            lat             Latitude
            lon             Longitude
            timezone        Timezone (tz)
            offset          Timezone UTC DST offset in seconds
            currency        National currency
            isp             ISP name
            org             Organization name
            as              AS number and organization, separated by space (RIR). Empty for IP blocks not being announced in BGP tables.
            asname          AS name (RIR). Empty for IP blocks not being announced in BGP tables.
            reverse         Reverse DNS of the IP (can delay response)
            mobile          Mobile (cellular) connection
            proxy           Proxy, VPN or Tor exit address
            hosting         Hosting, colocated or data center
            query           IP used for the query


SELECT * FROM `Navigations` n
LEFT JOIN `NavigationsParameters` np ON n.`navID`=np.`navId`  
ORDER BY `n`.`navDate` DESC;

SELECT ne.*, e.*
FROM `Navigations-Events`ne
RIGHT JOIN `Navigations`n ON n.`navID`=ne.`xhrId`
LEFT JOIN `Events` e ON ne.`event_code`=e.`eventCode`  
ORDER BY `ne`.`eventDate` DESC

SELECT ne.*, e.*, ed.*
FROM `EventsDatas`ed
RIGHT JOIN `Navigations-Events`ne ON ne.`eventID`=ed.`eventId`
LEFT JOIN `Events` e ON ne.`event_code`=e.`eventCode`
ORDER BY `ne`.`eventDate` DESC

DELETE FROM `Users-Cookies` WHERE `userId` IN (SELECT `userID` FROM `Users` WHERE `lastname`='makinson') ORDER BY `userId` ASC;
DELETE FROM `Users-Cookies` WHERE `cookieId`='VIS' AND `userId` IN (SELECT `userID` FROM `Users` WHERE `mail` IS NULL) ORDER BY `userId` ASC;
DELETE FROM `Navigations`;
DELETE FROM `Users` WHERE `lastname`='makinson' ORDER BY `userId` ASC;
DELETE FROM `Users` WHERE `mail` IS NULL;

ALTER TABLE `Navigations` DROP FOREIGN KEY `fk_userId.Pages-FROM-Users`; ALTER TABLE `Navigations` ADD CONSTRAINT `fk_userId.Pages-FROM-Users` FOREIGN KEY (`userId`) REFERENCES `Users`(`userID`) ON DELETE RESTRICT ON UPDATE CASCADE;

UPDATE `DiscountCodes` SET `nbUse` = '1' WHERE `DiscountCodes`.`discountCode` = 'free_shipping_be';
UPDATE `DiscountCodes` SET `nbUse` = '0' WHERE `DiscountCodes`.`discountCode` = 'free_shipping_ca';
UPDATE `DiscountCodes` SET `nbUse` = '-1' WHERE `DiscountCodes`.`discountCode` = 'summer20';
UPDATE `DiscountCodes` SET `nbUse` = NULL WHERE `DiscountCodes`.`discountCode` = 'winter30';


INSERT INTO `Basket-DiscountCodes` (`userId`, `discount_code`, `setDate`) 
VALUES ('3330090', 'blackfriday25', '2020-12-09 00:00:00'), ('3330090', 'free_shipping_be', '2020-12-08 00:00:00')