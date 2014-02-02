-- Diamond Search database tables removal --
-- NOTE: This script will remove all Diamond Search tables that store search index --
TRUNCATE TABLE `ddrdiamondsearch_toindex`
TRUNCATE TABLE `ddrdiamondsearch_terms`;
TRUNCATE TABLE `ddrdiamondsearch_term2field`;
TRUNCATE TABLE `ddrdiamondsearch_term2article`;
