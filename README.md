# kiind-php-demo <img src="http://img.shields.io/badge/status-awesome-lightgrey.svg" />

"Cash for Clicks" - B2C Marketing Idea

This project is a PHP rewrite of http://quidprize.com which was originally written in Python Django. It combines a gift-card disbursement service (<a href="https://www.kiind.me">Kiind.me</a>) with a shortlink/tracking service (<a href="http://ow.ly">ow.ly</a> or <a href="http://goo.gl/">goo.gl</a>). 

The basic model is that a business creates a "Campaign" to drive clicks to their website by offering a prize such as a giftcard (to their own business!); users can participate in the campaign by generating and sharing shortlinks; with each click the user directs towards the company website as part of the campaign, they increase their chances of winning the prize.

# Packages Used

See `composer.json` to get the full list of packages, but the main technologies used here:

- Twig
- Doctrine2
- Kiind API (see <a href="https://www.kiind.me">kiind.me</a>)
- Shortlinking API's (ow.ly, goo.gl)

