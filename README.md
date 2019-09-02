# PopIn

Displays pop-ins: informations displayed on top of the pages of your store.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is PopIn.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/pop-in-module:~1.0
```

## Usage

Pop-ins displays are organized into campaigns. You can manage campaigns on the module configuration page,
accessible through the module configuration link on the module page, or through the tools menu.
Here you can add, edit or remove campaigns.

A pop-in campaign can run for a specific period.
If a start date is selected, the pop-in will only be displayed after this date.
If an end date is selected, the pop-in will not be display after this date.
You can plan multiple campaigns at once.

The pop-in content can come from different sources:
 
 - **Content**: A Thelia content
 - **Image**: An image from a Thelia content in the *Pop-in images* folder
 - **Template**: A custom template in your front-office theme
 - **Hook**: The `pop-in.content` hook will be called to render the pop-in

The currently running campaign will be displayed to your visitors the first time they visit a page of your store
(if you configure multiple campaign running at once, only the one created first will run).
