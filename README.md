# Commentable - Ratings Extension

Provides ability to submit a rating along with the other fields in a comment.

Requires
* [Flynsarmy.Commentable](https://octobercms.com/plugin/flynsarmy-commentable) plugin 

## Installation

* `git clone` to */plugins/flynsarmy/commentableratings*
* `php artisan plugin:refresh Flynsarmy.CommentableRatings`
* Copy *views/partials/comments* to your themes *partials/comments* folder to override your `comment` components default partials.

If using the example 5 star rating code (requires Bootstrap, Font Awesome and jQuery), add the following CSS to your site:
```css
.star-rating .fa-star {cursor:pointer}
.star-rating .fa-star.checked {color:#eea022}
```
and JavaScript:
```javascript
// Make star ratings work in comments
$(document).on('mouseleave', '.commentable .star-rating.settable', function() {
	$('.fa-star', this)
		.removeClass('checked')
		.slice(0, jQuery(':hidden:first', this).val()).addClass('checked');
}).on('mouseenter', '.commentable .star-rating.settable .fa-star', function() {
	$(this).prevAll().andSelf().addClass('checked');
	$(this).nextAll('.fa-star').removeClass('checked');
}).on('click', '.commentable .star-rating.settable .fa-star', function() {
	$(this).nextAll(':hidden:first').val(
		$(this).prevAll().length + 1
	);
});
```

## Description

This is a simple plugin that adds a -10 to 10 rating value to each comment. It
also provides `comments` component partials to set a 1-5 star rating on your sites
frontend during comment creation. Feel free to change this to any other system
you like - thumbs up/down, total score value etc.

## API

This plugin adds the following methods/properties:

`Flynsarmy\Commentable\Models\Thread`:
* `getPositiveRatings()` - (int) Returns the number comments with ratings above 0.
* `getNegativeRatings()` - (int) Returns the number comments with ratings below 0.
* `getAverageRating()` - (int) Returns the average rating value of comments with ratings, rounded to the nearest integer.

`Flynsarmy\Commentable\Models\Comment`:
* `rating` - (int) A rating value from -10 to 10.