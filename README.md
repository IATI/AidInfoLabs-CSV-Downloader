# AidInfoLabs CSV Coversion & Download tool

Converts an IATI Registry file into a CSV, with the following options:

Simple activity summary (CSV)
*Top-level information with a row for each aid activity. Total figures for each type of transaction. Sector codes are included as a ';' separated list. Useful for basic research.*

Full activity data (CSV)
*Full flattened version of each IATI Activity record - one row per activity. Where multiple values exist for a column (e.g. multiple sectors, or many transactions) these are separated by ';'.*

All transactions (CSV)
*Detailed list of all transactions, with currencies, amounts and classifications with a row for each transaction.*

A live instance of this code is available at: http://tools.aidinfolabs.org/csv/direct_from_registry/


## Technology overview
Build using PHP and XSLT conversion files.


## Set-up

### Prerequisites:

Known requirements are:
- PHP
- UNIX environment

### Getting the code running on a local computer

In your UNIX environment, open a terminal and follow these commands:

```
# Clone the repository 
https://github.com/IATI/AidInfoLabs-CSV-Downloader.git

# Navigate into the directory
cd AidInfoLabs-CSV-Downloader

# Run the PHP built-in server
php -S localhost:8000

# Open a webbrowser and go to http://localhost:8000/
```

## Acknowledgements

The original developer is unknown, although footer text suggest this code was developed by Practical Participation for aidinfo labs using XSLT based on work by Rob McKinnon.
