$recipes = file('<filename>', FILE_IGNORE_NEW_LINES);

$recipes = array_map('json_decode', $recipes);

$latestRecipes = array_slice($recipes, -2);