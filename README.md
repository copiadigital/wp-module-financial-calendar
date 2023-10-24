# How to use

1. ### Initialize field by using wp-cli

   _Run from your local machine, in a new terminal tab_
   ```sh
   wp financial_calendar financial_calendar_init
   ```

---
2. ### Enabling calender in page builder

  To enable calendar builder layout, go to `Builder.php` under to your sage theme. Search Calendar and uncomment it.
  
  _Uncomment this line of code:_
  ```sh
  // ->addLayout($this->get(Calendar::class), [
  //     'label' => 'Calendar',
  //     'display' => 'block',
  // ])
  ```

---
3. ### Enabling calender in views template

  To enable calendar in views template, go to `resources/views/partials/builder` directory & edit `layout_container.blade.php`.
  
  _replace this line of code:_
  ```sh
  @includeFirst([
    'partials.builder.' . $build['acf_fc_layout'],
  ], $build)
  ```

  _with this line of code:_
  ```sh
  @includeFirst([
    'partials.builder.' . $build['acf_fc_layout'],
    'FinancialCalendar::partials.builder.' . $build['acf_fc_layout']
  ], $build)
  ```

4. ### Overriding the templates by using wp-cli

   _Run from your local machine, in a new terminal tab_
   ```sh
   wp financial_calendar financial_calendar_default
   ```

---
5. ### Altering taxonomies

  We can use `financial_calendar_tax_before_insert` hook in the filter.php to alter taxonomy. For example we want to remove taxonomy type

   _For removing type taxonomy. Paste this inside the filter.php_
   ```sh
    add_filter( 'financial_calendar_tax_before_insert', function ( $types ) {
      unset($types[1]);
      return $types;
    });
   ```


