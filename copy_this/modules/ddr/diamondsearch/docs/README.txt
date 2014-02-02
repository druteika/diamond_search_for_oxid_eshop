==Title==
Diamond Search CE

==Author==
Dmitrijus Druteika

==Prefix==
ddr

==Version==
0.1.0 beta

==Link==
http://www.druteika.lt/#diamond_search_for_oxid_eshop

==Mail==
dmitrijus.druteika@gmail.com

==Description==
Diamond Search - Simply brilliant out-of-the-box search engine for OXID eShop!
 - Search by all relevant article fields, categories, manufacturers, vendors, variants selections and attributes
 - Excellent performance even with large amount of articles
 - Search field auto-complete function
 - Easily configurable search options in administration back-end
 - Customize fields to search by, set ranking options, add Your custom fields
 - Multi-shops and multilingual shops support
 - No server configuration, to integrations, no setup or indexing effort - just install the module and activate it!
 - Articles will index for first time and re-index on changes automatically
 - Configurable search filters (soon!)
 - Unit tests provided (EE, PE editions only)
 - Monitor page with useful search statistics and indexing state (EE, PE editions only)
 - Personalized auto-complete hints (EE, PE editions only)
 - Ultimate cache mechanism for extreme performance (EE, PE editions only)

==Extend==
 * oxcmp_shop
   -- render
 * oxarticle
    -- save
    -- delete
 * oxarticlelist
 * oxsearch
    -- getSearchArticles
    -- getSearchArticleCount

==Installation==
Copy everything from copy_this package folder to Your OXID eShop root directory.
Activate the module in administration backend.
That's it!
