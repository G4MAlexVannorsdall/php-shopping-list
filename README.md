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
### View only the items that have not been ticked off

To view the items on a list that have not been completed(ticked off), provide the list name.

```bash
php scripts/shopping.php non-ticked-off supplies
```
