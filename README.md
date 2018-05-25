[![Latest Stable Version](https://poser.pugx.org/cubear/drupal-8-starter-kit/v/stable)](https://packagist.org/packages/cubear/drupal-8-starter-kit)
[![Latest Unstable Version](https://poser.pugx.org/cubear/drupal-8-starter-kit/v/unstable)](https://packagist.org/packages/cubear/drupal-8-starter-kit)

# Drupal 8 + Composer "starter-kit"
_**(...and CircleCI, and Pantheon, and...)**_

**_[Skip to Pantheon + GH + CircleCI Instructions](#pantheon--gh--circleci-instructions)_**

This project is a Drupal 8 codebase based on [drupal-composer/drupal-project](https://github.com/drupal-composer/drupal-project), [drupal-composer/drupal-scaffold](https://github.com/drupal-composer/drupal-scaffold), [pantheon-systems/example-drops-8-composer](https://github.com/pantheon-systems/example-drops-8-composer), plus the changes I had to make to be able to upgrade to the 4.x branch of Drupal 8 -- a process that wasn't *super* easy, b/c of some gaps in my knowledge, and oh btw the 4.x branch relies on a newer major version of Symfony :D  FWIW, this d.o thread was extremely helpful for me: https://www.drupal.org/node/2874827 (Drush 8.x doesn't install Drupal 8.4.x and Drush master doesn't install Drupal 8.3.x)

**IMPORTANT: This is a _starter kit_, there's no connection between this starter-kit and child sites post-install.  Think of it like you would think of an install profile in D7, rather than a distribution in D7.**  (Except this is D8...)<br />@todo: say more things here...

CU Bear distro packages: https://packagist.org/packages/cubear/

**Note:** This distro uses the Bootstrap-based custom theme [cwd_base_bootstrap](https://github.com/CU-CommunityApps/cwd_base_bootstrap), and the custom admin theme [cwd_admin](https://github.com/CU-CommunityApps/cwd_admin).  Please take care in updating these theme packages on "child sites" built from this starter kit.

@todo: mention possible "Ivy" distro

@todo: table of contents for this README

## What's inside

* `drupal-composer/drupal-project` (https://github.com/drupal-composer/drupal-project)
* upgraded Drupal core to 8.4.x
  * which included changes to composer.json from the regular drupal-composer/drupal-project
    * ps this was somewhat of a nightmare -- apparently 8.4.x requires a newer major version of symfony, and that caused all sorts of pain...
    * this thread was one of my main resources: https://www.drupal.org/node/2874827
* custom theme packages (included via composer)
* added some of the pantheon files from [pantheon-systems/example-drops-8-composer](https://github.com/pantheon-systems/example-drops-8-composer)
* added all config from our working demo site (omitted link)
  * (if you work with me, ping me and I'll give you the site UUID for importing the config)
* @todo: add a few more details from what's on confluence (i.e. ctypes)

### See also

Refer to the [drupal-composer/drupal-project](https://github.com/drupal-composer/drupal-project) and [drupal-composer/drupal-scaffold](https://github.com/drupal-composer/drupal-scaffold) README docs for more info about those projects, and how to use them (and therefore how to use this project).

Refer to the [pantheon-systems/terminus-build-tools-plugin](https://github.com/pantheon-systems/terminus-build-tools-plugin) README for more info about using `terminus build:project:create` (below) and other `build` funtionality.

## Usage
**_[Skip to Fancypants Pantheon + GH + CircleCI](#pantheon--gh--circleci-instructions)_**

**NOTE:** For best results, regardless of which instructions you use, make sure your Drush version is updated to the latest stable 8.x version.  Also, a global install will make your life easier, but it isn't required.  _[Drush install/upgrade instructions](http://docs.drush.org/en/8.x/install/#installupgrade-a-global-drush)_

### Simple, LOCAL-ONLY site
1. `git clone git@github.com:CU-CommunityApps/cubear-starter-kit.git ajm-cubear-vanilla`
1. `cd ajm-cubear-vanilla`
1. `composer install`
1. Then install drupal using the *config_installer* install profile (via UI, or `drush`).

**That's it! :)**  Enjoy your new Drupal 8.4.x + composer site!

### For a Pantheon site
(i.e. on Pantheon but without the GH/CircleCI jazz)

These instructions are similar to "Basic," but unfinished :)  @todo: Basically, create an empty pantheon site, clone the repo down, completely replace the code with the code from THIS repo, run composer install, update .gitignore so you can commit all those composer-generated artifacts to the repo, push back to pantheon, and then proceed with the process above -- using terminus drush commands, and skipping the "cd" commands of course; probably will need to wipe the database that was created by the Pantheon "drops 8" install, before anything else; may need to edit the "upstream" setting for the site from `drops-8` to `empty`. (If necessary, add back in the site UUID manipulation steps that used to be in the "Basic" instructions.)

### Vanilla-er
The `vvanilla` branch is a much plainer codebase -- no config or Pantheon files -- see my [commit #7d4a62e message](https://github.com/CU-CommunityApps/cubear-starter-kit/commit/1de45592d7780a2aa0fe16943078b4771ec73c25) for more info.

### Pantheon + GH + CircleCI instructions
(aka "Fancypants")

#### Prerequisites
* Drush 8.x -- latest stable version (Drush 8.1.13 as of 2017-09-27): http://docs.drush.org/en/8.x/install/#installupgrade-a-global-drush
* Terminus 1.x -- https://github.com/pantheon-systems/terminus#installation
* `terminus-build-tools-plugin` -- need to use 2.x branch (as of 2017-08-22 there's a 2.0.0-alpha2 tag)
* Create or edit ~/.terminus/config.yml (in your local env), to add a "starter site shortcut" [like these examples](https://github.com/pantheon-systems/terminus-build-tools-plugin/tree/2.0.0-alpha2#starter-site-shortcuts).
    1. Mine contains the following:<br />
    ```
    command:
      build:
        project:
          create:
            shortcuts:
              cubear-starter-kit: cubear/drupal-8-starter-kit:dev-master
    ```

**IMPORTANT:** When you're done, do **NOT** make changes/commits to your new site codebase from the GH interface -- there's a .gitignore thing from the Pantheon template, that's totally on-purpose, but it means that files will be lost if you commit in GH, so we might need to undo that, idk yet.

#### Other heads-ups:
* You'll be prompted for GitHub and CircleCI personal access tokens, but the prompts have documentation links, so just follow those as you go along.
    * Alternatively, you can set your tokens ahead of time like this:
https://github.com/pantheon-systems/terminus-build-tools-plugin/tree/2.0.0-alpha2#credentials
* You'll also be prompted for a password for "user 1" on the new site you're about to create; personally, I leave it blank and use `drush user-login` after installation, i.e.<br />
`terminus drush ajm-cubear-vanilla.dev -- uli`
    * "user 1" username will be "admin."
* **IMPORTANT:** While most of the build takes care of itself, toward the end you'll get two "authenticity of host can't be established" prompts -- make sure you type "yes"!!

#### The actual instructions!
1. Run `terminus build:project:create` with the applicable options -- my command looks like this:<br />
`terminus build:project:create --team="cornell-university-cornell-information-technologies" --org="CU-CommunityApps" --admin-email="cd-drupal-l@list.cornell.edu" cubear-starter-kit ajm-cubear-vanilla`
    1. Full documentation is over in the `terminus-build-tools-plugin` README, but briefly: `--org` is to set the child site's GitHub repo to be owned by an org (if you leave the option off, it will be owned by your personal GitHub account -- you can always transfer ownership to later), `--admin-email` is the email to use for Drupal user 1 (defaults to your personal GitHub account email), `cubear-starter-kit` is the shortcut we set during "Prerequisites" above, and `ajm-cubear-vanilla` is the name of my new Pantheon site and GitHub repo.
1. Now, clone the repo FROM github to your local, do work locally, and push changes back up to github -- that will trigger CircleCI builds, and eventual merging of changes into "dev" on Pantheon.
    1. OR, better, yet, create a new branch locally and use a Pull Request workflow :)

## Next steps: Your "child site"
_This info applies to a child site created via [Fancypants instructions](#pantheon--gh--circleci-instructions)._
(@todo: finish this...)

**Clone your child site GitHub repo:**<br />
`git clone git@github.com:CU-CommunityApps/ajm-cubear-vanilla.git`
    * You'll need to have <a href="https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/">set up an SSH key situation with your local machine + GitHub</a> -- if you haven't, either do that now, or use the HTTPS method for cloning the repo instead:<br />
    `git clone https://github.com/CU-CommunityApps/ajm-cubear-vanilla.git`
* Do all code changes in here!!
* Ideally, create branches for each set of changes you make, then create pull requests within the GitHub GUI to merge those changes into `master`.
* CircleCI will create builds any time there's a new branch, and whenever you create a pull request.
    * (@todo: does it create a build when you commit changes to an existing branch / add to an existing PR? -- 20180322: yes)
* Remember, the starter-kit is just a starter-kit -- **you are responsible for updating modules/core/other packages used by your project.**
    * Run `composer install` from the root directory of your project.  (@todo: link to composer- and composer-plus-drupal-related documentation...)
    * Run `drush` commands one level down, in `web`.
* Use composer to get theme updates, just like you would with contrib modules. (i.e. change the version spec for cwd_base_bootstrap and cwd_admin when a new version is released)
* Then, use a branch + pull request workflow to make changes to the codebase...
    * Similar to pull request workflow below, for demo site, but not the same b/c child sites should not be kept in sync with the starter-kit.
    * (@todo add more info...)

### Also...
* Optionally, update the README in your new site repo with the CircleCI badge, so that it's easier to get from your repo to that project's CircleCI things (for some reason the badge isn't getting automatically added right now).  You can get the "status badge" embed code by going to your project on CircleCI ([example](https://circleci.com/gh/alisonjo2786/ajm-cubear-vanilla)) > settings gear at top-right > "status badge" in left sidebar menu.
* Check your "Basic site settings" (admin/config/system/site-information) and Update Manager settings (admin/reports/updates/settings).
* Add Google Analytics
    * [Google Analytics Lite](https://www.drupal.org/project/google_analytics_lite) -- **one setting**: GA tracking ID.  _@todo: find out if this lite module lets you exclude authenticated users -- probably not, but worth checking_
        * Most likely 100% fine if you're going to do all your data analysis in the GA interface anyway.
    * [Google Analytics](http://drupal.org/project/google_analytics) -- more features/settings
* Add a non-administrator user role!!  (Even if it's just an "almost everything but protected from really dangerous stuff" role.) _@todo: new role is planned for starter-kit config; when done, remove this instruction..._
* Enable and configure SSO _@todo: instructions :)_
* #### In Pantheon dashboard...
    * Configure redis https://pantheon.io/docs/redis/ (enable the add-on in Pantheon, update settings.php, enable the Drupal module _[enabling module via Drupal site, NOT dashboard]_)
    * Enable NewRelic.
    * Enable daily/weekly backups in Pantheon (if service level allows).
    * Update "service level" to Personal or Professional or whatever, in Pantheon (**if applicable**).  _@todo: link to Pantheon service request form thing that's on IT@C... (for requesting the professional service)_

## Contribution
@todo: more instructions for updating/contributing to this starter kit? (beyond the PR workflow below)<br />
@todo: mention possible "Ivy" distro

### Pull request workflow
_(Open to suggestions!)_
1. Fork this repo to your own account, i.e. `alisonjo2786/cubear-starter-kit`.
1. Clone your fork locally.  **DO NOT** make commits in the GitHub UI (b/c .gitignore things).
1. Add and rename remotes...
    1. `git rename origin ajmfork`
        1. **Maybe** run `git remote -v` first, to confirm the name of your repo fork remote (in case it isn't "origin").
    1. `git remote add cu-community-repo git@github.com:CU-CommunityApps/cubear-starter-kit.git`
1. Make sure you're up to date with all the latest things:<br />
`git remote update`
1. Create a new branch where you'll do your work, **from the main repo:**<br />
`git checkout -b news-date-field cu-community-repo/master`
1. Work.
1. Commit changes.
1. Check the main repo in case other changes have been committed in the meantime -- if changes **have** been committed in the meantime, rebase your copy of the repo with those changes:<br />
`git remote update`<br />
`git rebase cu-community-repo/master` <-- Grabs commits from the main repo, inserts them into your branch, and sticks your local commit(s) on the end.
1. Push branch up to your fork -- so now, `alisonjo2786/cubear-starter-kit` has a branch called `news-date-field`:<br />
`git push ajmfork`
1. In GitHub, go to the branch on your fork, and start a pull request.<br />
"Your recently pushed branches" > "Compare & pull request"
    1. Check the two branches that GitHub is presenting to you -- the desired setup is for "base fork" to be the main repo ("CU-CommunityApps/cubear-starter-kit" > "master"), and for the "head fork" to be your fork ("alisonjo2786/cubear-starter-kit" > "news-date-field").
    1. Add whatever description/comment.
    1. Submit the PR.
1. @todo: determine and describe code review and approval process...
1. If you have permission to update/commit to the main repo, technically you can merge the PR into the main repo, but proper devops is for someone other than you to review and merge.

#### Update the demo site
_(Open to suggestions!)_
Unlike other "child sites," it's important to keep the demo site up to date with the starter-kit!  The demo site is called "gold-bear" -- more information and links are [on the GH repo](https://github.com/CU-CommunityApps/gold-bear).
1. Clone the `gold-bear` repo: (see above re: "SSH key situation")<br />
`git clone git@github.com:CU-CommunityApps/gold-bear.git`
1. Go to your local copy of `gold-bear` repo.
1. One-time (initial setup) -- you need a branch off to the side that tracks the starter-kit repo.
    1. Add a secondary remote to the main `cubear-starter-kit` repo:<br />
    `git remote add cubear-starter-kit git@github.com:CU-CommunityApps/cubear-starter-kit.git`
    1. Create a branch that tracks `cubear-starter-kit` > `master`:<br />
    `git checkout -b sk-master --track cubear-starter-kit/master`
1. Go to branch that tracks the starter-kit repo:<br />
`git checkout sk-master`
1. Pull from the main repo to this branch:<br />
`git pull cubear-starter-kit` _(this definitely works, I just don't remember if there's a better way)_
1. Check the commits that come in -- like, browse the whole log, or look for the commit(s) you know you want to add to the demo site.  Make note of the commit sha/hash details that you need.<br />
`git log`
1. Go back to `master` and create a new branch for the changes (yep, another PR coming! get excited!):<br />
`git checkout -b coffee-update`
1. Cherry pick the commits from the starter-kit tracking branch (`sk-master`) -- personally, I prefer to use `-x` for cherry-picks, i.e.<br />
`git cherry-pick -x a1s2d3f4g5h6jcommithash`
1. Push the branch up to the `gold-bear` repo, create a pull request, do pull request things.
    1. **Keep an eye on CircleCI** -- it will do a build for the new branch, and the PR, and when the PR is merged into master.
    1. When the process is done, the commits in the PR will have been merged into dev/master on Pantheon, too -- then you can `drush cim` or whatever.
        1. If it's just composer updates that are needed, those will be handled by the build tools stuff that Pantheon does.
1. Clean up the branch (`coffee-update`) in the GitHub GUI, and locally:<br />
`git branch -D coffee-update`<br />
`git remote prune origin`

#### git remote config tips
* Rename your remotes to minimize confusion, i.e.<br />
`@todo`
* If you're updating the `gold-bear` demo site, too, add a secondary remote to your local copy of that repo, and an extra branch that tracks the starter-kit repo, so you can pull down starter-kit code updates and then grab applicable commits as needed.  In other words:<br />
`@todo`


#### config installer thing
`@todo` add "re-export configuration from demo site" to contribution instructions, somewhere.
