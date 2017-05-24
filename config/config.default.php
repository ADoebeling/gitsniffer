<?php

namespace www1601com\Agenturtools;

/**
 * Default location to search for git root (toplevel)
 */
const gitPath = __DIR__.'/../../';

/**
 * Show the git version
 *
 * @example git version 2.0.4
 */
const cmdGitVersion = 'git --version';


/**
 * Parse the git version
 *
 * @example 2.0.4
 */
const regExGitVersion = '/git version (.*)/';


/**
 * Show the path to the git top-level
 *
 * @example /var/www/project.com/www/
 * @see http://stackoverflow.com/questions/12293944
 */
const cmdGitRootPath = 'git rev-parse --show-toplevel'; //


/**
 * Parse the path to the git top-level
 *
 * @example /var/www/project.com/www/
 */
const regExGitRootPath = '/(.*)/';


/**
 * Show the git status (we only use the headline)
 */
const cmdGitStatus = 'git status -b --porcelain';


/**
 * Parse the git status headline
 */
const regExGitStatus = '## ([\w\d\/\-.]*)(?:\.\.\.)([\w\d\/\-.]*)(?: \[(?:ahead (\d*))?(?:(?:, )?behind (\d*))?\])?';


/**
 * Show all files from git status with mode and modified date
 *
 * @example
 * MODE=" D" MODIFIED="" FILE="3"
 * MODE=" D" MODIFIED="" FILE="4"
 * MODE=" M" MODIFIED="2017-05-21 14:23:34.288550354 +0200" FILE="1"
 * MODE="??" MODIFIED="2017-05-21 09:44:40.428401928 +0200" FILE="htdocs/"
 * MODE="??" MODIFIED="2017-05-21 14:22:48.369673948 +0200" FILE="5"
 *
 * @see http://stackoverflow.com/questions/14141344
 */
const cmdGitStatusFiles = 'IFS=\'\'; git status --porcelain | while read -n2 mode; read -n1; read file; do echo MODIFIED=\"$(stat -c %y "$file" 2> /dev/null)\" FILE=\"$file\" MODE=\"$mode\" SIZE=\"$(stat -c %s "$file" 2> /dev/null)\" DISKSIZE=\"$(du -s $file 2> /dev/null)\" TYPE=\"$(stat -c %F "$file" 2> /dev/null)\"; done|sort';


/**
 * Parse the git status result
 *
 * Full match  0-115    `MODE=" M" MODIFIED="2017-05-23 17:44:03.000000000 +0200" FILE="class/cmd.class.php" SIZE="2883" TYPE="regular file"`
 * Group 1.    7-8      `M`
 * Group 2.    20-39    `2017-05-23 17:44:03`
 * Group 3.    63-82    `class/cmd.class.php`
 * Group 4.    90-95    `2883`
 * Group 5.    102-114  `regular file`
 *
 * @see https://regex101.com/r/l7QyRg/1
 */
const regExGitStatusFiles = '/MODIFIED=\"([\d-: ]*).*\" FILE=\"(.*)\" MODE=\".(.)\" SIZE=\"(\d*)\" DISKSIZE=\"(\d*).*\" TYPE=\"(.*)\"/';


/**
 * Show the file-diff between filesystem and git, limited to XX rows
 *
 * @example
 * diff --git a/gitsniffer.class.php b/gitsniffer.class.php
 * deleted file mode 100644
 * index e4a031e..0000000
 * --- a/gitsniffer.class.php
 * +++ /dev/null
 * @@ -1,286 +0,0 @@
 * -<?php
 * -
 * -namespace ADoebeling;
 * -require_once 'php-github-api/vendor/autoload.php';
 */
const cmdGitDiff = 'git diff --minimal | head -n20';


const cmdGitBranch = 'git branch';

const regExGitBranch = '/\* (.*)/';

/**
 * Parse file-diff
 */
const regExGitDiff = '/(.*)/';

/** Shall the displayed hostname gets determined by gethostname() or by the reverse-dns of the ip of the hostname*/
const getHostnameByReverseDns = false;

/** Only affects customer of the german hoster domainfactory */
const getHostnameWithManagedServerWorkaround = true;

const cmdGetHostnameByReverseDns = 'dig +short -x $(dig +short %s)';

const regExGetHostnameByReverseDns = '/(.*)\./';


const reminderText = "Sorry for disturbing, but the [GitSniffer](https://github.com/ADoebeling/Agenturtools) ".
    "found some changes that aren\'t committed yet. Please review the `git status`/`git diff` below and update your ".
    "repository. Thanks a lot!\n\n".

    "**Branch:** `%BRANCH%`\n".
    "**Path:** `%PATH%`\n".
    "**Host:** `%HOSTNAME%` (`%IP%`)\n\n".

    "%GITSTATUS%\n\n".
    "%GITDIFF%\n\n".

    "<!-- This issue was auto-generated by GitSniffer. (C) @ADoebeling -->";