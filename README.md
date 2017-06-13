# Fleaflicker exporter
Fleaflicker doesn't have any built-in export options. This tool will scrape the pages, grabbing the necessary information (Team Name, Player Name, Plaery Position). This tool assumes the league type is "NFL".


## Out of the box usage
1. Clone the repository in a local directory.
2. Using a command line tool, change to the directory you just cloned to.
3. Find your Fleaflicker league number. Hint: It's the last number in the url when looking at all of the teams in your league (eg. `https://www.fleaflicker.com/nfl/leagues/1234`) 
4. Type `php download_league.php [league id]` eg `php download_league.php 1234` and press enter. (Hopefully it's obvious by now, but this requires php.)

A new csv file will be created in the "files" sub-directory. The file will be named with the league id followed by a timestamp eg (`1234-2017-01-01T00:00:00Z.csv`)

