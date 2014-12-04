# CiviCRM Widget Creation Interface (WCI) Extension

## Overview

This is a CiviCRM CMS independent extension for creating and managing embeddable widgets which can showcase content from various CiviCRM properties like Donate links to contribution pages, Contribution status as progressbar, Malinglist signup forms, html text etc. The Widget Creation Interface (WCI) offer the flexibility to CiviCRM users to customize the look and feel of the widgets.

## Prerequisite

- CMS. (Preferably Drupal Version 7.x)
- CiviCRM Version 4.7.x or above

## Features

- CiviCRM users can create embeddable widgets using existing CiviCRM compontents like Contribution pages as well as Mailinglists.
- Progress bars can be created and added to widgets which draws its value from a formula including values from one or more contribution pages
- We have seperated the embed code and widgets so that it is possible to change the widget appearing in a website without chaning the embed code.
- It is possible to cache the widget generated to reduce the load on the CiviCRM server.

### Progress bar

To draw a progress bar we need a starting amount, goal amount and current amount. Using 'Create Progress bar' (civicrm/wci/progress-bar/add) form user can set these information. Current amount for the progress bar is taken from the contributions done in the selected Civi Contribution page. User can select multiple source contribution pages and percentage of amount to take from those contribution pages for calculating current amount in the progress bar. By clicking save the information is saved to database and form gets forwarded to 'Manage Progress bar' page. There user can edit or delete already created progress bars.

### Widget

A lot of widget properties can be set here. User can give colors, texts, image for the widget and its elements. There is provision to show either amount or percentage on top of the progress bar in the widget. Also can hide or show border, title, and progress bar caption. Advanced users can override default template by checking 'Override' check box. At that time they have to provide custom template code which should be based on smarty v2.

Mailing list Groups can be added using Civi Group(civicrm/group/add?reset=1). To get that group in the CreateWidget form check 'Mailing List' check box only.

By clicking Save and Preview button information will be saved to the database and a sample widget will be displayed on top of the form. To go to the Manage Widget page click 'Save' button. There user can edit, or delete existing widgets.

### Embed Code

To use the widget in other web sites, user has to create embed code. This can be done in 'New Embed Code' (civicrm/wci/embed-code/add) form. Select a widget, give a title and save and preview, it will show the preview of the widget and embed code that can be used in other web sites. Click 'Save' to save and go to 'Manage Embed Code' page where user can edit or delete existing embed codes.

### Settings

Mailing list subscription feature also exposed though widget. To use that first create a Profile and set the visibility as public. Then in that profile add field of type 'contact' as 'email'. Add one more field 'contact' as 'group'. Use 'Public Pages' for 'Visibility'. Note the profile id. Use this id in the Widget Settings(civicrm/wci/settings) for Default profile.

For getting better performance WCI widget uses a cache system. A timeout value can be provided 'Widget cache timeout' field for saving the widget in database for that specified time. Static widgets (widgets with out progress bar) will be caches permanently unless there is any change in the widget.

### Permission

There are 2 permissions associated with CiviWCI.
'Administer CiviWCI' : All WCI menu items are available for user of this permission. Please enable it in your CMS permission page.

'Access CiviWCI Widget' : To see the widget the user should have this permission. Enable this to anonymous users too, if they want to view the widget.

CiviCRM-WCI development is sponsored by [Zyxware Tehnologies](http://www.zyxware.com).
