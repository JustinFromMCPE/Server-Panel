# Launchpad Administrative Minecraft Panel
#### Welcome to my panel, or I guess, *your* panel. This panel was built with [Bootstrap 4](v4-alpha.getbootstrap.com), PHP, Javascript, and Java. That being said, Launchpad has many cool features (some still in the works!), as well as full mobile support and constant visual updating, for the best look and functionality.
##### Ok, so why don't I use Multicraft?
 Well, here are a couple issues with Multicraft:
 - It costs money
 - Old versions have very limited functionality
 - Old versions look old and lame
 - Lots of class injection

Ok, so why should I use your panel?
My panel has many features out of the box, and more coming:
 - It's 100% free!
 - Open source
 - No class injection
 - Modern look and feel
 - Mobile support
 - Easy setup

Planned Features:
 - Votifier
 - Full server.properties editor
 - Autorestart
 - Backups
 - More!

![alt-text](http://i.imgur.com/RS5lfrS.png?1 "Desktop View")
![alt-text](http://i.imgur.com/dvACOdj.png?1 "Mobile View")
## Hold up, what exactly *is* this?
This is a Minecraft server control panel, developed using a combination of PHP, JavaScript and Java. If that doesn't mean anything to you, it's basically a multicraft alternative; you would use it to access and control your server remotely.

## Installation
#### PHP
1. [Click here](http://php.net/manual/en/install.php) To learn how to install PHP on your system. Note, most Mac and Linux computers should come with PHP installed.
2. Enable sockets. Go to your php.ini file (/private/etc/php.ini.default on Macs, C:\PHP on PC, depends where you installed it, /etc/php.ini on Linux, most likely). Open the file in a text editor, and find the line `;extension=php_sockets.dll` and remove the `;`.

#### Panel
1. Move the `panel` and `server` folders to your preferred locations.
2. Open `server/config.properties` and fill `panel-directory` with the directory of the panel (eg: `C:\panel`).
3. Notice the `port` setting. This must always be set to the same as the `wrapper port` setting, in the panel.
4. Run `panel/start.bat` or `panel/start.sh`. This will open the website on the port 80 (default web port). If you are on a web server, you can skip this step, as long as you placed the `panel` folder in your dedicated website folder.
5. Put your desired Minecraft server jar into `/server/server/`. Proceed to open the panel (if you are on a local machine, go `http://localhost`) and set the name of your desired jarfile, in `panel-settings`. **NOTICE**: The default login credentials are "`admin`" and "`password`".
6. Run `server/start.bat` or `server/start.sh`. You can directly run the jar to run it in the background, however, this will make closing it very difficult
6.1. Forward your ports. If you're on a hosted machine, you probably can skip this step. If you're not, you must simply forward ports 80 and your desired Minecraft server port (usually 25565). However, do **not** forward your wrapper port (usually 8040).
7. You're done! Change your username and password, mess around. It's *your* panel, after all!

## FAQ
#### What are the requirements for using this?
Well, you need a computer/server to run this, along with your Minecraft server. This means, no hosted Minecraft servers and no website servers. Apart from that, this will run on most platforms, along with the installation of PHP.

#### How does this look on my phone/small device?
The panel was built using Bootstrap 4, so it would be a sin to not include mobile support. If your screen gets too small, the panel will snap to a more versatile layout.

#### Is this compatible with all versions of Minecraft?
This panel uses **no** class injection, which is a unique feature. This means that you can run not just any version of Minecraft, but literally any (theoretically) Java based program.

#### The overview tab isn't working?!?
Make sure that you have `enable-query` set to `true`, in your server.properties file.

#### This is cool and all, but it's pretty basic. Do you plan on adding more?
Of course, I have many things planned, fear not!

#### OMG something doesn't work!!!
Sorry, this panel is still *very* WIP. Create an issue thread, and I'll get to it ASAP.
