# HeatherscratchR
Source code for the Scratch 1.4 section of Heatherscratch. This is based on ScratchR by LLK.

It doesn't include the Scratch Forums, the Text-Based Games Forums, the Scratch Wiki, the stats site or any 2.0-styled page, including the 2.0 Wiki. How to get them will be added to the install guide one day or another.

Differences over the original ScratchR:
- Parts of the [Scratch Documentation Site](https://web.archive.org/web/20110411054144/http://info.scratch.mit.edu/) were added
- The Scratch 1.4 Downloads Page was added
- The early Scratch 2.0 maintenance page was added (Scratch 1.4 had no maintenance page)
- The Halloween 2009 logo was added
- The Wiki icon was added
- The Scratch Suggestions icon was added

For an exact list of modified file, see [here](https://github.com/heathercat123/HeatherscratchR/compare/cd6146e..master).

## Installation
Follow [this guide](https://github.com/heathercat123/HeatherscratchR/discussions/3), but:
- Skip to the *Install MariaDB* step
- To install MariaDB: `sudo apt install mariadb-server-10.1 mariadb-client-10.1`
- To install PHP: `sudo apt install php php-mysql php-gd php-memcache php-mbstring`
- Remove `extension=mysql.so` from php.ini
- To clone ScratchR: `git clone --single-branch -b php7 https://github.com/heathercat123/HeatherscratchR.git scratchr`

For now, the installation instructions don't include how to get the forums, the tbg forums, the wiki or the statistics site.
