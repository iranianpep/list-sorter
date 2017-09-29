# List Sorter
List Sorting Handler in Laravel

[![Latest Stable Version](https://poser.pugx.org/list-sorter/list-sorter/v/stable)](https://packagist.org/packages/list-sorter/list-sorter)
[![Build Status](https://travis-ci.org/iranianpep/list-sorter.svg?branch=master)](https://travis-ci.org/iranianpep/list-sorter)
[![Build Status](https://scrutinizer-ci.com/g/iranianpep/list-sorter/badges/build.png?b=master)](https://scrutinizer-ci.com/g/iranianpep/list-sorter/build-status/master)
[![Code Climate](https://codeclimate.com/github/iranianpep/list-sorter/badges/gpa.svg)](https://codeclimate.com/github/iranianpep/list-sorter)
[![Test Coverage](https://codeclimate.com/github/iranianpep/list-sorter/badges/coverage.svg)](https://codeclimate.com/github/iranianpep/list-sorter/coverage)
[![Code Coverage](https://scrutinizer-ci.com/g/iranianpep/list-sorter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/iranianpep/list-sorter/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/iranianpep/list-sorter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/iranianpep/list-sorter/?branch=master)
[![Issue Count](https://codeclimate.com/github/iranianpep/list-sorter/badges/issue_count.svg)](https://codeclimate.com/github/iranianpep/list-sorter)
[![License](https://poser.pugx.org/list-sorter/list-sorter/license)](https://packagist.org/packages/list-sorter/list-sorter)
[![StyleCI](https://styleci.io/repos/105158982/shield?branch=master)](https://styleci.io/repos/105158982)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/f6798ce3c00e4de083d89f289b6c9285)](https://www.codacy.com/app/iranianpep/list-sorter?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=iranianpep/list-sorter&amp;utm_campaign=Badge_Grade)
[![Packagist](https://img.shields.io/packagist/dt/list-sorter/list-sorter.svg)](https://packagist.org/packages/list-sorter/list-sorter)
[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/iranianpep/list-sorter/master/LICENSE)

## Usage
```
$listSorter = new ListSorter($request, [
    new SortableItem('title'),
    new SortableItem('created_at'),
]);

$listSorter->setDefaultSortBy('created_at');
$listSorter->setDefaultSortDir('desc');

// sort by e.g. title or created_at
$sortBy = $listSorter->getSortBy();

// sort direction e.g. asc or desc
$sortDir = $listSorter->getSortDir();
```