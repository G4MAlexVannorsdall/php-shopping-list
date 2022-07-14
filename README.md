# Shopping List

This is a simple shopping list application, written in PHP. It uses Domain Driven Design (DDD) and a CQRS (Command
Query Responsibility Separation) structure.

## Usage

### Create a Shopping List

Provide a slug (dasherised lower case name) and a list title to the following command:

```bash
php scripts/shopping.php create-list my-groceries "My Groceries"
```

Use the slug when running other commands for this lists.

### View a Shopping List

To view the items on a shopping list, use the `view-list` command with the list's slug:

```bash
php scripts/shopping.php view-list my-groceries
```

### Add a Shopping Item

To add a shopping item to a list, provide the list slug and the name of the item to add:

```bash
php scripts/shopping.php add-item my-groceries "Wholemeal Bread"
```

### Mark Shopping Item as Ticked-Off

To mark a shopping item as completed (ticked-off), provide the list slug and either:

- The name of the item; or
- The number of the item on the list.

For example:

```bash
php scripts/shopping.php complete-item my-groceries "Wholemeal Bread"
```

Or to tick off item number 2:

```bash
php scripts/shopping.php complete-item my-groceries 2
```

### Mark a Shopping list as archived

To mark a shopping list as archived, provide the list slug.
```bash
php scripts/shopping.php archive-list my-groceries
```
If all items on the list are ticked off, the list will automatically be marked as archived.

### Mark a Shopping list as deleted

To mark a shopping list as deleted, provide the list slug.
```bash
php scripts/shopping.php delete-list my-groceries
```
