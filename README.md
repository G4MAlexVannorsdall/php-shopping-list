# Shopping List

This is a simple shopping list application, written in PHP.

## Usage

### Create a Shopping List

Provide a slug (dasherised lower case name) and a list title to the following command:

```bash
php scripts/shopping.php create-list my-groceries "My Groceries"
```

Use the slug when running other commands for this lists.

### Add a Shopping Item

To add a shopping item to a list, provide the list slug and the name of the item to add:

```bash
php scripts/shopping.php add-item my-groceries "Wholemeal Bread"
```
