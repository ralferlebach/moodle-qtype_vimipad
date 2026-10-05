moodle-qtype_vimipad
====================

[![Moodle Plugin CI](https://github.com/ralferlebach/moodle-qtype_vimipad/actions/workflows/moodle-ci.yml/badge.svg?branch=main)](https://github.com/ralferlebach/moodle-qtype_vimipad/actions?query=workflow%3A%22Moodle+Plugin+CI%22+branch%3Amain) [![ViMi Pad: Question type](https://img.shields.io/badge/ViMi%20Pad-Question%20type-0f6cbf)](https://ralferlebach.github.io/Moodle-ViMiPad-Plugins/)

The ViMi Pad question type lets learners answer a quiz question by drawing a knowledge map, and marks that answer automatically against the reference map the author drew.

ViMi Pad is not a single plugin but a family of four that work as one system. They are released
together, carry the same version number and the three satellites declare the activity as a
dependency, so a satellite is only ever as current as the activity it was qualified against.

* **mod_vimipad** is the editor and the data model: it owns the map itself - nodes, relations, containers, revisions, snapshots, annotations and grades - and exposes the public map API that the other three build on.
* **mod_vimigallery** is the reading view: it shows a set of maps as an album, one at a time, embedded on the course page or behind a link.
* **qtype_vimipad** turns a map into a quiz question: learners answer by drawing, and the answer is marked automatically against a reference map.
* **datafield_vimipad** adds a map as a field type in the Database activity, so a map can be one column of a collection.

This README documents **qtype_vimipad** - the third bullet point above. The other three plugins are
documented in their own repositories.

Because the responsibilities are split this way, this plugin stores no map logic of its own. The
answer a learner draws is validated and rendered by the activity, and the question engine keeps it
like any other response.


Requirements
------------

This plugin requires Moodle 4.5+

It also requires the ViMi Pad activity, declared as a dependency in version.php and installed in the
same version (currently 1.0.0 / 2026100500):

* **mod_vimipad (ViMi Pad)** - required dependency: the question embeds its editor and validates answers through its map API\
  https://github.com/ralferlebach/moodle-mod_vimipad


Motivation for this plugin
--------------------------

A multiple-choice question can ask whether a learner recognises a relationship. It cannot ask them
to lay out how a set of concepts hangs together, which is the thing a concept map is good for.

Marking such an answer by hand does not scale beyond a seminar group. This plugin makes the drawing
itself the response: the learner answers by building a small map, and the engine compares it with
the reference map the author drew, so the question works in an ordinary quiz with ordinary grading.


Installation
------------

Install the plugin like any other plugin to folder
/question/type/vimipad

See http://docs.moodle.org/en/Installing_plugins for details on installing Moodle plugins


Usage & Settings
----------------

After installing the plugin, it is ready to use. Create a question of type "ViMi Pad" in the question
bank and add it to a quiz like any other question.

The question type has no site-wide settings. Each question decides its own: which diagram form the
answer must follow, which node shapes are allowed, and how it is marked. Upload a reference map
exported from ViMi Pad and the answer is scored by how much of that structure it reproduces; leave
it empty and the question falls back to a minimum number of concepts and relations.

If you want to learn more about using question types in Moodle, please see https://docs.moodle.org/en/Question_types.


Capabilities
------------

This plugin does not add any additional capabilities.


Scheduled Tasks
---------------

This plugin does not add any additional scheduled tasks.


How this plugin works / Pitfalls
--------------------------------

The learner's answer is a map, stored as the question's response by Moodle's question engine. That
means everything the engine already does applies: attempts, regrading, review and the question bank
all work as they do for any other question type.

Scoring compares concepts and propositions against the reference map. How strictly labels must match
is a per-question choice: exactly, ignoring word order and stop words, or tolerating typos.

**Pitfall:** the reference map has to fit the question's own settings. If you change the diagram form
or the allowed shapes after uploading a reference, the question refuses the mismatch instead of
silently marking against a reference nobody could have drawn.

**Pitfall:** automatic marking rewards structure, not insight. For questions where the wording of a
proposition matters, a manual review of the attempts is still the honest route.

Theme support
-------------

This plugin is developed and tested on Moodle Core's Boost theme.
It should also work with Boost child themes, including Moodle Core's Classic theme. However, we can't support any other theme than Boost.


Plugin repositories
-------------------

This plugin is not published in the Moodle plugins repository.

The latest development version can be found on Github:
https://github.com/ralferlebach/moodle-qtype_vimipad

An overview of the whole plugin family is published at:
https://ralferlebach.github.io/Moodle-ViMiPad-Plugins/


Bug and problem reports / Support requests
------------------------------------------

This plugin is carefully developed and thoroughly tested, but bugs and problems can always appear.

Please report bugs and problems on Github:
https://github.com/ralferlebach/moodle-qtype_vimipad/issues

We will do our best to solve your problems, but please note that due to limited resources we can't always provide per-case support.


Feature proposals
-----------------

Due to limited resources, the functionality of this plugin is primarily implemented for our own local needs and published as-is to the community. We are aware that members of the community will have other needs and would love to see them solved by this plugin.

Please issue feature proposals on Github:
https://github.com/ralferlebach/moodle-qtype_vimipad/issues

Please create pull requests on Github:
https://github.com/ralferlebach/moodle-qtype_vimipad/pulls

We are always interested to read about your feature proposals or even get a pull request from you, but please accept that we can handle your issues only as feature _proposals_ and not as feature _requests_.


Moodle release support
----------------------

Due to limited resources, this plugin is only maintained for the most recent major release of Moodle as well as the most recent LTS release of Moodle. Bugfixes are backported to the LTS release. However, new features and improvements are not necessarily backported to the LTS release.

Apart from these maintained releases, previous versions of this plugin which work in legacy major releases of Moodle are still available as-is without any further updates in the Moodle Plugins repository.

There may be several weeks after a new major release of Moodle has been published until we can do a compatibility check and fix problems if necessary. If you encounter problems with a new major release of Moodle - or can confirm that this plugin still works with a new major release - please let us know on Github.

This plugin is designed to be compatible with all currently supported versions of Moodle, leveraging its latest APIs. However, if you are using a legacy version of Moodle, we kindly advise against installing or using this plugin. Instead, we strongly recommend updating your Moodle instance to a supported version to ensure security and compliance with current technological standards. Thank you for your understanding.


Translating this plugin
-----------------------

This Moodle plugin is provided with English and German language packs only. Translations into other languages must be managed through AMOS (https://lang.moodle.org), where they will become part of Moodle's official language pack.

As the plugin creator, we continue to maintain the German translation. For all other languages, we kindly ask you to contribute your translations directly in AMOS. These contributions will be reviewed by Moodle's official language pack maintainers before being included in the official repository.

Thank you for supporting the global Moodle community!


Right-to-left support
---------------------

This plugin has not been tested with Moodle's support for right-to-left (RTL) languages.
If you want to use this plugin with a RTL language and it doesn't work as-is, you are free to send us a pull request on Github with modifications.


Maintainers
-----------

The plugin is maintained by\
Ralf Erlebach


Copyright
---------

The copyright of this plugin is held by\
Ralf Erlebach

Individual copyrights of individual developers are tracked in PHPDoc comments and Git commits.
