Support PostgreSQL
===================

Zermelo is a reporting engine that is a decidely MySQL oriented reporting engine that runs on top of old versions of the Laravel project.

There are three main types of Reports in Zermelo:

* Card
* Tablular
* Graph

Card and Tabular are mostly just different views on similarly structured reporting engine.

The graph reporting engine is unique. It supports the ability to create a D3 Graph browser, from raw SQL.
The SQL must conform to a specific pattern, but assuming the query is aliased correctly. The Graph reporting
engine supports the ability to query and diaplay graphs with SQL, and then display them as a graph which is a bit of a trick.

I would like you to read the following reports classes:

* app/Reports/AlmasFavoriteCards.php
* app/Reports/TEST_NorthwindCustomerReport.php
* app/Reports/CreatureClass.php
* app/Reports/RegClusterGraph.php
* app/Reports/DURC_card.php
* app/Reports/PersonCreatureGraph.php
* app/Reports/CardTest.php

It is a little confusing because the purpose of the LoreCommander project is to track a card game and there is a "Card" report type.
But the latter refers to a bootstrap card based report. So please be aware of that confusion as you read the reports.

Then read the relevant parts of the Zermelo reporting system. That includes everything in the ../Zermelo/src directory and subdirectories.

Once you have read that, I would like to understand what the options might be for supporting PostGreSQL.

I can think of a couple of options:

* Write a whole parallel set of php classes that work in the same way, are prefixed with Pg and are invoked when using PostGreSQL. This approach would enable the support of very specific code to support the details of MySQL and PostGreSQL differently.
* Write each SQL in the code twice, once for PostGreSQL and once for MySQL and have a flag that flows through the code depending on which database is configured to be used.
* Use a library of some kind as an abstraction layer
* Restrcuture the classes so that the SQL is isolated from the logic entirely, and has a PostGreSQL and MySQL version in those new classes.
* Some other plan I have not thought of

Generally, the approach taken by the Reporting engine is to run complex SQL queries once and then to serve up the results from a Cache in _zermele_cache.
For tabular and card reports, the reporting engine makes a single cache table.
For the graph reports, there are seperate databases for nodes, node_types, node_groups and edges. Then forms these into a JSON file that can be consumed by the
very bespoke d3-based javsacript graph frontend browser that we have. This graph browser is very complex and for the time being please exclude it from your analysis.
Just know that if the library generates the right JSON from PostGreSQL as it does from MySQL then the front-end should be happy.

The tabular graph reporting engine has a sophisticated understanding of the various column types that it supports.
The graph reporting engine takes the opposite approach it collapses everything to a varchar representation that it then converts to JSON.

As you read the SQL, please pay attention to requirements for specific MySQL database setup. The reporting engine currently supports MyISAM for instance.
As well as hacks to get the database to properly handle different collations and character sets.

Please read everything. Ask any questions that you need to, and then give a summary of the benifits between the various approaches, and how much each one would be.


The Actual Plan: 
=================

### Step 1: Create a Comprehensive Test Suite

Before making any changes to the codebase, it's crucial to establish a "safety net" to ensure we don't break existing functionality.

- __Objective:__ To create a set of automated tests that verify the output of each existing report. This will allow us to confidently refactor the code, knowing that we can immediately detect any regressions.

- __Process:__

  1. __Set up a test environment:__ I will use a dedicated test database populated with a small, consistent set of data to ensure that tests produce predictable results every time they are run.
  2. __Write tests for each report:__ For each of the report classes (`AlmasFavoriteCards`, `TEST_NorthwindCustomerReport`, etc.), I will create a corresponding test case.
  3. __Validate report output:__ Each test will execute a report and compare its output (or a hash of the output) against a pre-recorded, known-good result. This will confirm that the SQL queries are correct and the data is being processed as expected.
  4. __Leverage existing test hooks:__ I will investigate the `testMeWithThis()` static function within the `ZermeloReport` class, as it appears to be a built-in mechanism for defining test parameters for each report.

### Step 2: Implement Dual SQL Queries for MySQL and PostgreSQL

Once the test suite is in place, I will begin implementing PostgreSQL support by providing alternative queries.

- __Objective:__ To modify the system so that it can execute the correct SQL dialect based on the currently configured database connection, without changing the core logic of the reports.

- __Process:__

  1. __Detect the database driver:__ In every location where SQL is generated (primarily the `GetSQL()` method in report classes and the generator classes like `ReportGenerator` and `GraphGenerator`), I will add logic to check the current database driver (e.g., using Laravel's `DB::connection()->getDriverName()`).

  2. __Provide parallel SQL statements:__ Based on the driver detected (`mysql` or `pgsql`), the method will return the appropriate SQL string.

  3. __Translate MySQL-specific code:__ I will translate all MySQL-specific functions and syntax to their PostgreSQL equivalents. This includes:

     - __Functions:__ `IF()` becomes `CASE`, `CONCAT()` becomes the `||` operator or the standard `CONCAT()` function, `FROM_UNIXTIME()` becomes `to_timestamp()`, etc.
     - __Syntax:__ Backticks for identifiers will be replaced with standard double quotes, and `COLLATE` clauses will be removed or adapted for PostgreSQL.

  4. __Run tests:__ After modifying each report or generator, I will run the test suite against both a MySQL and a PostgreSQL database to verify that the output remains correct for both platforms.
