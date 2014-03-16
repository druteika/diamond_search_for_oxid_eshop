Diamond Search CE RC3
=====================

Diamond Search - Simply brilliant out-of-the-box search engine for OXID eShop!
------------------------------------------------------------------------------

 - Search by all relevant article fields, categories, manufacturers, vendors, variants selections and attributes
 - Search field auto-complete function
 - Configurable search filters
 - Unlimited Multi-shops and multilingual shops support
 - No server configuration, to integrations, no setup or indexing effort - just install the module and activate it!
   Articles will index for first time and re-index on changes automatically
 - Excellent performance even with large amount of articles
 - Easily configurable search options in administration back-end
 - Customize fields to search by, set ranking options, add Your custom fields
 - Unit tests provided (EE, PE editions only)
 - Monitor page with useful search statistics and indexing state (EE, PE editions only)
 - Personalized auto-complete hints (EE, PE editions only)
 - Ultimate cache mechanism for extreme performance (EE, PE editions only)
 
What's new in v0.2.x
--------------------
 - Search filters
    - Fields configuration allows to set filter option
    - Search filters sidebar widget introduced
    - Color filter has special colored style for simple color names
    - Filter results are stored in session and processed on background
 - Configurable option - Index on change. Article is indexed immediately on save.
 - Article extends model support created, fields added to default configuration
 - Added configurable search statistics saving
 - Structure changes
    - Fields configuration file is now named config.php
    - All sample attributes area added to default fields configuration
    - Module is now independent of DB views - unlimited multi-shops and languages are supported
    - Database tables indexes were optimized for best performance
    - Cron script now has more documentation inside comments
 - Bug fixes:
    - Cron script messages format fixed
    - Faulty article indexing "trap" fixed
    - Save hooks for models are fixed to set required fields on firs save only
	- Sorting by price and title fixed
	- Older versions support added
    - Other minor fixes

How to install the module
-------------------------
 - Copy everything from copy_this package folder to Your OXID eShop root directory.
 - Activate the module in administration back-end.

That's it!
Optionally adjust module settings (in administration back-end) and configure cron (see cron.php script comments).
