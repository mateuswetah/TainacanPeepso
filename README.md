# Tainacan Peepso

This repository contains a plugin for integrating [Tainacan](https://tainacan.org) with [Peepso](https://www.peepso.com). It was built based on the [HelloWorld sample plugin](https://gitlab.com/PeepSo/Public/HelloWorld) created by the Peepso team.

Right now this is in a prototype stage. These are the remaining steps to make it more usable:

- [ ] Add the collection creation flow on the Peepso side (for now it has to be created inside Tainacan);
- [ ] Better customize the [Profile Collections list](templates/tainacan/profile-tainacan-collections.php);
- [ ] Better customize the [Profile Items list](templates/tainacan/profile-tainacan-collection.php), particularly the filters modal;
- [ ] Fix the bug that brings items from every collection whenever the item edition modal is closed;
- [ ] Customize the items list templates (collection, repository and taxonomy term - levels);
- [ ] Customize the item single page template;

But really, this would be much more interesting if we could add the following features:

- [ ] Use Peepso comments form on the item page, so we can see notifications, etc. Maybe [this](https://www.peepso.com/documentation/filter-commentsbox_display/) would do it?;
- [ ] Publish something in the user feed every time someone adds or edits an item or collection;
- [ ] Maybe add a share option to share Tainacan items instead of images.

Feel free to contribute if you have any knowledge on both plugins.
