ComponentManagerPhpDocbook
==========================

**ComponentManagerPhpDocbook** contains the code and data used by the [phix](http://www.phix-project.org) commands for creating and maintaining manuals for PHP components.

System-Wide Installation
------------------------

ComponentManagerPhpDocbook is normally installed when you install [phix4componentdev](http://github.com/stuartherbert/phix4componentdev)

    sudo pear channel-discover pear.phix-project.org
    sudo pear -D auto_discover=1 install -Ba phix/phix4componentdev

As A Dependency On Your Component
---------------------------------

If you are creating a component that relies on ComponentManagerPhpDocbook, please make sure that you add ComponentManagerPhpDocbook to your component's package.xml file:

```xml
<dependencies>
  <required>
    <package>
      <name>ComponentManagerPhpDocbook</name>
      <channel>pear.phix-project.org</channel>
      <min>2.0.0</min>
      <max>2.999.9999</max>
    </package>
  </required>
</dependencies>
```

Usage
-----

This component adds the 'php-docbook:' set of commands to phix.

To see all of the commands available, do:

    # phix built-in help
    phix

To get help on the individual php-docbook commands, do:

    # php-docbook built-in help
    phix help php-docbook:init
    phix help php-docbook:status
    phix help php-docbook:upgrade

Development Environment
-----------------------

If you want to patch or enhance this component, you will need to create a suitable development environment. The easiest way to do that is to install phix4componentdev:

    # phix4componentdev
    sudo apt-get install php5-xdebug
    sudo apt-get install php5-imagick
    sudo pear channel-discover pear.phix-project.org
    sudo pear -D auto_discover=1 install -Ba phix/phix4componentdev

You can then clone the git repository:

    # ComponentManagerPhpDocbook
    git clone git://github.com/stuartherbert/ComponentManagerPhpDocbook.git

Then, install a local copy of this component's dependencies to complete the development environment:

    # build vendor/ folder
    phing build-vendor

To make life easier for you, common tasks (such as running unit tests, generating code review analytics, and creating the PEAR package) have been automated using [phing](http://phing.info).  You'll find the automated steps inside the build.xml file that ships with the component.

Run the command 'phing' in the component's top-level folder to see the full list of available automated tasks.

License
-------

See LICENSE.txt for full license details.
