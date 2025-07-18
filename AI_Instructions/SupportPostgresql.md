Support PostgreSQL
===================


### Step 1: Create a Comprehensive Test Suite

Before making any changes to the codebase, it's crucial to establish a "safety net" to ensure we don't break existing functionality.

- __Objective:__ To create a set of automated tests that verify the output of each existing report. This will allow us to confidently refactor the code, knowing that we can immediately detect any regressions.

- __Process:__

  1. __Set up a test environment:__ I will use a dedicated test database populated with a small, consistent set of data to ensure that tests produce predictable results every time they are run.

The following reports are the test reports. I should create a small test database for each one. 

[test_file](../../LoreCommander/app/Reports/TEST_AutoTagsReport.php)
[test_file](../../LoreCommander/app/Reports/TEST_CharTest.php)
[test_file](../../LoreCommander/app/Reports/TEST_graph_npi.php)
[test_file](../../LoreCommander/app/Reports/TEST_GraphTest.php)
[test_file](../../LoreCommander/app/Reports/TEST_LeadingZero.php)
[test_file](../../LoreCommander/app/Reports/TEST_ndh_endpoint.php)
[test_file](../../LoreCommander/app/Reports/TEST_NorthwindCustomerReport.php)
[test_file](../../LoreCommander/app/Reports/TEST_NorthwindCustomerSocketReport.php)
[test_file](../../LoreCommander/app/Reports/TEST_NorthwindOrderIndexReport.php)
[test_file](../../LoreCommander/app/Reports/TEST_NorthwindOrderReport.php)
[test_file](../../LoreCommander/app/Reports/TEST_NorthwindOrderSlowReport.php)
[test_file](../../LoreCommander/app/Reports/TEST_NorthwindOrderYearReport.php)
[test_file](../../LoreCommander/app/Reports/TEST_NorthwindProductReport.php)
[test_file](../../LoreCommander/app/Reports/TEST_TagsReport.php)

I will have to use a browser against the LoreCommander docker instance to test each of these reports.

Generally the tests for the report types vary by the class of report so:

ZermeloGraph/TEST_graph_npi is the url component to test the TEST_ndh_endpoint.php class, which extends from the AbstractGraphReport
Zermelo/Something is the url for the tabluar reports
ZermeloCard/Something is the url for the card reports. All of the card reports will also work as tabular reports.

In many cases the test database already exist. I should read: ./setup_db/ directory to find various database resources. Ignore lore.sql since that is the production LoreCommander database.
Lets see how many of these we can quickly get working. If you have trouble getting a test working lets skip it and move on to the next one. 

