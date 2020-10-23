<?php namespace Flynsarmy\CommentableRatings;

use Backend\Widgets\Form;
use Event;
use Flynsarmy\Commentable\Controllers\Threads;
use Flynsarmy\Commentable\Controllers\Notifications;
use Flynsarmy\Commentable\Models\Comment;
use Flynsarmy\Commentable\Models\Thread;
use System\Classes\PluginBase;

/**
 * Commentable Plugin Information File.
 */
class Plugin extends PluginBase
{
    public $require = ['Flynsarmy.Commentable'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Commentable - Ratings Extension',
            'description' => 'Adds option to submit a rating in comments',
            'author'      => 'Flynsarmy',
            'icon'        => 'icon-comments',
        ];
    }

    public function boot()
    {
        Thread::extend(function (Thread $model) {
            $model->addDynamicMethod('getPositiveRatings', function () use ($model) {
                return $model->comments->where('rating', '>', 0)->count();
            });
            $model->addDynamicMethod('getNegativeRatings', function () use ($model) {
                return $model->comments->where('rating', '<', 0)->count();
            });
            $model->addDynamicMethod('getAverageRating', function () use ($model) {
                return intval(round(
                    $model->comments->where('rating', '!=', 0)->avg('rating')
                ));
            });
        });

        Event::listen('backend.form.extendFields', function (Form $form) {
            if (!$form->getController() instanceof Threads &&
                !$form->getController() instanceof Notifications) {
                return;
            }

            // Only for the Comment model
            if (!$form->model instanceof Comment) {
                return;
            }

            $form->addFields([
                'rating' => [
                    'label' => 'Rating',
                    'type' => 'dropdown',
                    'options' => array_combine(
                        range(-10, 10),
                        range(-10, 10)
                    ),
                ],
            ]);
        });
    }
}
