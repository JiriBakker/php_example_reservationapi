Couverts PHP example code
=========================

[Couverts.nl](https://www.couverts.nl?utm_source=github&utm_campaign=examplecode&utm_medium=web) is a restaurant reservation platform. Over 2500 restaurants work with the intelligent digital reservation book that we have developed in-house. The reservation system is tailor-made and therefore perfectly suits the formula of any restaurant, contributing to optimum occupancy. 
On the B-to-B side, restaurants -more and more- have the need for a fully customised reservation flow on their own website or platform. 

This project consists of the PHP examplecode, which communicates withour reservation-API.
It can be used as a local working PHP example to build your own reservation form.

If you haven't got your API key / Restaurant ID yet, contact us today at +31 (0)35 711 3000, or by e-mail at developers@couverts.nl. We will generate an API key for you and your restaurant and send it to you immediately, so you can get started as soon as possible!

In the meantime, you can clone this project and check out the code (it won't be working yet, though).


Getting started
---------------

As mentioned above: to be able to use this example code, you need a restaurant ID and an API key.

1. Rename *config.default.php* to *config.php* and open it in your favourite text editor.
2. Fill in your API_KEY in *config.php*
3. Fill in your RESTAURANT_ID in *config.php*
4. Open your web browser and go to wherever you have your project is hosted, e.g.
http://localhost/couverts-php-example-code/

*That's it!*

You now have your own working example!

This example code is configured to communicate with our API in the testing environment (https://api.testing.couverts.nl, found in *config.php*). If you are satisfied with your website, you can change the endpoint URL to the live version. The live API endpoint is located at https://api.couverts.nl and requires a different set of credentials. **BEWARE!** When you're working in the live environment, you will be making **real** reservations! Be sure to let everyone know you're testing and **don't forget to cancel your test reservations!**

Documentation
-------------

You can find more documentation in our [Swagger page: https://api.testing.couverts.nl/swagger](https://api.testing.couverts.nl/swagger)

Notes
-------------

- We consciously did not use a PHP framework, because you may want to include this code in the framework of your own choice and/or to keep this example simple.
- Instead of using 'file_get_contents' (in ReservationService) you may want to consider using cURL to connect with the API because it makes handling for example response headers a lot easier. We used 'file_get_contents' for compatibility's sake (you may not have cURL installed).

Version information
-----------
This code has been tested on
- PHP 5.5.9 on Ubuntu 14.04
- PHP 7.0.5 on Ubuntu 14.04

