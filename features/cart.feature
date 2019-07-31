Feature: Cart functionality
  As a customer
  I want to add items to my cart
  So i can buy various products

  Background:
    Given the following products exists:
      | product_name | product_desc     | product_price | product_type | product_id |
      | Coke         | A bottle of coke | 0.8           | Soft Drink   | 1          |
      | Sandwich     | A sandwich       | 2             | Sandwich     | 2          |
      | Crisps       | Some crisps      | 0.75          | Crisps       | 3          |
    Then I should have "3" product in my repository

  @Monday_drink_discount
  Scenario Outline: I want to add coke(s) to my cart
    Given It is Monday
    When I add "<quantity>" "Coke" to my cart
    Then I should have "<quantity>" items in my cart
    And The total cost of my cart will be "<expected_cost>"

    Examples:
      | quantity | expected_cost |
      | 1        | 0.8           |
      | 2        | 0.8           |
      | 3        | 1.6           |

  @Crisps_discount
  Scenario: I want to add crisps to my cart
    Given I have no items in my cart
    When I add "2" "Crisps" to my cart
    Then I should have "2" items in my cart
    And The total cost of my cart will be "1"

  @Crisps_discount
  Scenario: I want to add crisps to my cart
    Given I have no items in my cart
    When I add "1" "Crisps" to my cart
    Then I should have "1" items in my cart
    And The total cost of my cart will be "0.75"

  @Common
  Scenario: I add a non-existent product to my cart
    Given I have no items in my cart
    When I try add a non-existent item to my cart
    Then I should get Product not found error.

  @Sandwich_menu
  Scenario Outline: I want to buy various products
    Given I have no items in my cart
    When I add "<crisps_quantity>" "Crisps" to my cart
    And I add "<coke_quantity>" "Coke" to my cart
    And I add "<sandwich_quantity>" "Sandwich" to my cart
    Then I should have "<cart_items>" items in my cart
    And The total cost of my cart will be "<price>"

    Examples:
      | crisps_quantity | coke_quantity | sandwich_quantity | cart_items | price |
      | 1               | 1             | 1                 | 3          | 3     |
      | 1               | 2             | 1                 | 4          | 3.8   |
      | 2               | 1             | 1                 | 4          | 3.75  |
      | 0               | 1             | 1                 | 2          | 2.8   |
      | 1               | 0             | 1                 | 2          | 2.75  |
      | 2               | 0             | 1                 | 3          | 3     |
