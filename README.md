# Racket Ladder v0.1

Automated ladder for racket sports (intended for clubs who want to keep an "internal ladder" for their members)

## WARNING : this is a quick & dirty PHP/MySQL prototype

* No authentication
* No security concerns checked
* No pagination
* No backend/frontend framework used
* Uses PHP globals
* All static text is in french language (+ suited for my local badminton club)

OBVIOUSLY NOT SUITED FOR ONLINE PRODUCTION PURPOSES.

However, it can be safely used on a computer / virtual machine if only accessible & used locally.

## Features

* List/add **players** (first name, last name)
* List/add **played sets** (winner, loser, x2 if doubles)
* Show **ladders** for the 5 supported **game types** (men singles, women singles, men doubles, women doubles, mixed doubles)
* At each **set** addition, new **players "values" (scores)**, thus their ranking in the game type's ladder, are computed automatically.
  Scores changes depends on :
  * Players "original" scores (right before the set was played), starting at 0
  * Wins/losses (obviously)
  * Number of sets already played before

**Notes for players**

* Your score will be "auto adjusted" according to your performance (particularly quickly when you are a newcomer).
* In order to get a good score (thus a better ranking) in the ladder, beat players with highest scores possible.
* You are advised to meet players in a range of +/-10pts around your score.
* A 100pts player winning a 10pts player will change nothing to scores/ladder.
* A 100pts player losing to a 10pts one, will show *significant* changes (depending on the number of sets already played).

## Requirements

* Webserver (Apache, nginx) with PHP >= 5.1
* MySQL >= 5.0

## Installation

As easy as any other simple PHP/MySQL basic app.

* Run SQL commands from `schema.sql` on your MySQL database
* Copy/paste PHP files in the directory of your choice 
* Edit `config.php` and set database info
