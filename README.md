Sistema Corretor
================

A coding system to help teachers provide a great learning experience to students
setting up programming challenge problems (ICPC-like problems).

Originally created to be used at Universidade Federal de Pernambuco (UFPE) for
algorithm classes because creating and grading such programming problems required
a lot of annoying work.

We're using:

* CodeIgniter (www.codeigniter.com)
* PHP
* MySQL
* Apache
* Java

Setting up
----------

You will need apache, php and mysql first. If you're running on Ubuntu 11.10, you can
install them with the following:

	sudo apt-get install apache2 php5 libapache2-mod-php5 mysql-server libapache2-mod-auth-mysql php5-mysql

And then run:
	
	sudo /etc/init.d/apache2 restart

If this doesn't work, just look for any other tutorial on google. :-)

Now go to the folder **/var/www/** (for Ubuntu) and clone this repository there. You may
need to change the permissions in this folder to copy this file. To clone it, just run:

	git clone https://rafaelbrandao@github.com/rafaelbrandao/Sistema-Corretor.git

Now you will need to fill some places with your database configuration (i.e username, password, etc.).
Files that need to be modified:

* "./application/config/config.php" : add an encryption key
* "./application/config/database.php" : fill your database data
* "./Corretor - Projeto/Corretor/configCorretor.cnf" : fill your database data

Now extracts **Corretor.jar** from ./Corretor - Projeto/Corretor.zip to ./Corretor - Projeto/Corretor/ folder.
Now, at this point, you should have everything working. :-)

Grading scores
--------------

You must run the process that will manage this task. Go to "./Corretor - Projeto/Corretor/" folder and run:

	java -jar Corretor.jar

It will keep fetching the judge queue and running user submissions as soon as something is there
Then it will generate the results and fill the database with them. You can either keep this always running
or just run it on demand (most recommended).

Contributing
------------

If you don't want to code but have found any bug, just check the current issues. If you can't find anything
related, then create a new one. If you have a contribution (good code I mean), then please fork this project, do your changes on your project, then commit it there.
Once you have the commit, link the issue with your commit and then wait until your changes are accepted.

As you had to modify some project files to run it, they will show up when you check status from git. So to avoid
the mistake of submitting your database changes as long as your patch, just mark those files as **unchanged** with:

	git update-index --assume-unchanged ./application/config/config.php ./application/config/database.php "./Corretor - Projeto/Corretor/configCorretor.cnf"

Thank you for using and/or contributing!
