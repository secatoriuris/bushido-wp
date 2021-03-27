var Tracker = require("../../../assets/js/components/insights/tracker");

var selectors = {
	accordions: ".helpie-faq.accordions",
	faqSearch: ".helpie-faq .searchWrapper .search__input",
	accordion: ".accordion",
	accordionHeading: ".accordion__heading",
	accordionHeadingShow: "accordion__heading--show",
	accordionHeadingHide: "accordion__heading--hide",
	accordionHeader: ".accordion .accordion__item .accordion__header",
	accordionItem: ".accordion__item",
	accordionItemShow: "accordion__item--show",
	accordionItemHide: "accordion__item--hide",
	emptySearchWrapper: ".search .searchEmptyWrapper",
	emptyFAQsContent:
		"<p class='searchEmptyWrapper__content'>" + faqStrings.noFaqsFound + "</p>",
};

var Stylus = {
	//setup before functions
	searchTerm: "",
	typingTimer: 0, // timer identifier
	doneTypingInterval: 2000, // time in ms, 2 second for example

	setSearchAttr: function () {
		/* Add 'search_attr' to accordion headers */
		jQuery(selectors.accordionHeader).each(function () {
			var searchAttr = jQuery(this).text().toLowerCase();
			jQuery(this).attr("data-search-term", searchAttr);
		});
	},

	isContentMatch: function (element, searchTerm) {
		var content = jQuery(element)
			.closest(selectors.accordionItem)
			.find(".accordion__body")
			.text()
			.toLowerCase();

		if (content.indexOf(searchTerm) >= 0) return true;

		return false;
	},

	isTitleMatch: function (element, searchTerm) {
		var searchContent = jQuery(element).attr("data-search-term");

		if (searchContent == undefined || searchContent == "undefined") {
			return false;
		}

		var searchIndex = searchContent.search(searchTerm);
		if (searchIndex != -1) {
			return true;
		}
		return false;
	},

	onSearchKeyup: function (that) {
		var thisModule = this;
		const searchTerm = thisModule.searchTerm;

		/* Loop through each accordion item header */
		jQuery(that)
			.closest(selectors.accordions)
			.find(selectors.accordionHeader)
			.each(function () {
				var TitleMatch = thisModule.isTitleMatch(this, searchTerm);
				var ContentMatch = thisModule.isContentMatch(this, searchTerm);

				var show = TitleMatch || ContentMatch;
				if (show == true) {
					jQuery(this)
						.closest(selectors.accordionItem)
						.removeClass(selectors.accordionItemHide)
						.addClass(selectors.accordionItemShow);

					var accordionItem = jQuery(this)
						.closest(selectors.accordionItem)
						.closest(".accordion__body")
						.closest(selectors.accordionItem);

					if (accordionItem.length > 0) {
						accordionItem.show();
					}
				} else {
					jQuery(this)
						.closest(selectors.accordionItem)
						.removeClass(selectors.accordionItemShow)
						.addClass(selectors.accordionItemHide);
				}
			});

		/**
		 * When "Simple Accordion by Category" display mode is used, the search filter should bring
		 * only the particular faq searched for and the category title it belongs to.
		 * It should not bring the category titles of FAQ's not searched for.
		 */

		jQuery(that)
			.closest(selectors.accordions)
			.find(selectors.accordion)
			.each(function () {
				var totalItems = jQuery(this).find(selectors.accordionItem).length;

				var hiddenItemsCount = 0;

				var accordionHeading = jQuery(this)
					.prev(selectors.accordionHeading)
					.text()
					.toLowerCase();

				if (accordionHeading.indexOf(searchTerm) >= 0) {
					// shown heading, accordion and faq-items only for display mode as "Simple Accordion by Category"
					jQuery(this)
						.prev(selectors.accordionHeading)
						.removeClass(selectors.accordionHeadingHide)
						.addClass(selectors.accordionHeadingShow);

					jQuery(this).show();
					jQuery(this)
						.find(selectors.accordionItem)
						.removeClass(selectors.accordionItemHide)
						.addClass(selectors.accordionItemShow);
				} else {
					jQuery(this)
						.find(selectors.accordionItem)
						.each(function () {
							if (jQuery(this).css("display") === "none") {
								hiddenItemsCount = hiddenItemsCount + 1;
							}
						});

					if (totalItems == hiddenItemsCount) {
						jQuery(this).hide();
						jQuery(this)
							.prev(selectors.accordionHeading)
							.removeClass(selectors.accordionHeadingShow)
							.addClass(selectors.accordionHeadingHide);
					} else {
						jQuery(this).show();
						jQuery(this)
							.prev(selectors.accordionHeading)
							.removeClass(selectors.accordionHeadingHide)
							.addClass(selectors.accordionHeadingShow);
					}
				}
			});
	},

	init: function () {
		var thisModule = this;
		console.log("Search init");
		thisModule.setSearchAttr();
		jQuery("body").on("keyup", selectors.faqSearch, function (event) {
			var searchValue = jQuery(this)
				.val()
				.toLowerCase()
				.replace(/[.*+?^${}()|[\]\\]/gi, "");

			thisModule.searchTerm = searchValue;

			// don't show the empty faqs block, if users entering the keywords for filtering faqs
			thisModule.canSeeEmptyFAQsBlock(this, "hide");

			if (thisModule.searchTerm == "") {
				// show all faqs, if search term has an empty.
				thisModule.showAllAccordions(this);
				return false;
			}
			var searchTerm = thisModule.onSearchKeyup(this);

			// shown not found faq's content
			thisModule.showEmptyFAQsContent(this);

			// use of condition for avoid to tracking empty search term.
			if (thisModule.searchTerm == "") {
				return false;
			}

			// For ajaxCall, start the countdown
			clearTimeout(thisModule.typingTimer);
			thisModule.typingTimer = setTimeout(function () {
				// donetyping() method
				// For Tracking, searching Keywords
				Tracker.searchCounter(searchTerm);
			}, thisModule.doneTypingInterval);
		});
	},

	showAllAccordions: function (that) {
		jQuery(that)
			.closest(selectors.accordions)
			.find(selectors.accordion)
			.each(function () {
				let item = jQuery(this);

				//show accordion
				item.show();

				//show heading
				item
					.prev(selectors.accordionHeading)
					.removeClass(selectors.accordionHeadingHide)
					.addClass(selectors.accordionHeadingShow);

				//show accordion items
				item
					.find(selectors.accordionItem)
					.removeClass(selectors.accordionItemHide)
					.addClass(selectors.accordionItemShow);
			});
	},
	showEmptyFAQsContent: function (that) {
		var hiddenFaqsCount = 0;

		var totalFaqsCount = jQuery(that)
			.closest(selectors.accordions)
			.find(selectors.accordionItem).length;

		jQuery(that)
			.closest(selectors.accordions)
			.find(selectors.accordionItem)
			.each(function () {
				// count all hidden faqs
				if (jQuery(this).is(":visible") == false) {
					hiddenFaqsCount = parseInt(hiddenFaqsCount) + 1;
				}
			});

		// check hidden faqs-count with overall faq-count, return if not match both counts.
		if (hiddenFaqsCount != totalFaqsCount) {
			return;
		}

		// append & show the not found faq text block
		jQuery(that)
			.closest(selectors.accordions)
			.find(selectors.emptySearchWrapper)
			.empty()
			.show()
			.append(selectors.emptyFAQsContent);
	},

	canSeeEmptyFAQsBlock: function (that, status) {
		var canSeeElement = "none";
		if (status == "show") {
			canSeeElement = "block";
		}
		jQuery(that)
			.closest(selectors.accordions)
			.find(selectors.emptySearchWrapper)
			.css("display", canSeeElement);
	},

	displayHeading: function (event, canDisplay) {
		const addClassName =
			canDisplay == true
				? selectors.accordionHeadingShow
				: selectors.accordionHeadingHide;

		const removeClassName =
			canDisplay == false
				? selectors.accordionHeadingHide
				: selectors.accordionHeadingShow;

		event.removeClass(removeClassName).addClass(addClassName);
	},
};

module.exports = Stylus;
