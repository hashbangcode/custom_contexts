# Custom Context Providers Example Drupal Module

This is an example Drupal module on how to create your own custom context
providers and how to use them in your projects. This is suitable for
Drupal 9 and 10.

The following context providers are available:
- IP Address Context - Looks up the user's IP address.
- Random IP Address Context - Generates a random IP address.
- Node Random Context - Loads a random published node from the database.
- Referenced Node Context - Loads a node referenced from the route node
- through the field field_referenced_article.
- Multiple String Context - Example context provider showing how to return
multiple values.

The following blocks are avaiable:
- IP Context Block - Shows the users IP address using the IP Address context
provider.
- Node Context Block - Shows how to load a node through the context provider.
- User Context Block - Show how to load a user through the context provider.

For more information on this please see the following articles:
- [Drupal 10: Using Context Definitions To Create Context Aware Plugins](https://www.hashbangcode.com/article/drupal-10-using-context-definitions-create-context-aware-plugins)
- [Drupal 10: Creating Custom Context Providers](https://www.hashbangcode.com/article/drupal-10-creating-custom-context-providers)
