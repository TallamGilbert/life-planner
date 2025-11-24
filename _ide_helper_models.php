<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property numeric $amount
 * @property string|null $category
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $date
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Expense whereUserId($value)
 */
	class Expense extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $streak
 * @property int $longest_streak
 * @property \Illuminate\Support\Carbon|null $last_completed
 * @property string|null $description
 * @property string|null $category
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereLastCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereLongestStreak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereStreak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Habit whereUserId($value)
 */
	class Habit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property \Illuminate\Support\Carbon $date
 * @property string $meal_type
 * @property string|null $recipe
 * @property string|null $ingredients
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereIngredients($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereMealType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereRecipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Meal whereUserId($value)
 */
	class Meal extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Expense> $expenses
 * @property-read int|null $expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Habit> $habits
 * @property-read int|null $habits_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Meal> $meals
 * @property-read int|null $meals_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

