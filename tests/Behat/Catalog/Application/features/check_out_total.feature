Feature: Check out total
  In order to get total
  I need to be able to scan items

  Rules:
  - Item "A" costs $50.0
  - Item "B" costs $30.0
  - Item "C" costs $20.0
  - Item "D" costs $15.0
  - Special offer - Buy 2 "A"'s for $90.0
  - Special offer - Buy 3 "A"'s for $130.0
  - Special offer - Buy 2 "B"'s for $45.0

  Scenario: Scan a single item "A"
    Given there is a "A", which costs $50.0
    When I scan the "A"
    Then the total should be $50.0

  Scenario: Scan two "A" items
    Given there is a "A", which costs $50.0
    When I scan the "A"
    And I scan the "A"
    Then the total should be $100.0

  Scenario: Scan item "A" and item "B"
    Given there is a "A", which costs $50.0
    And there is a "B", which costs $30.0
    When I scan the "A"
    And I scan the "B"
    Then the total should be $80.0

  Scenario: Scan three items "A" with a special offer - Buy 3 "A"'s for $130.0
    Given there is a "A", which costs $50.0
    And there is a pricing rule for "A", which costs $130.0 for 3 items
    When I scan the "A"
    And I scan the "A"
    And I scan the "A"
    Then the total should be $130.0

  Scenario: Scan item "A" three time, item "B" and "C" two times, item "D" one time
            with special offers - Buy 3 "A"'s for $130.0 and Buy 2 "B"s for $45.0
    Given there is a "A", which costs $50.0
    And there is a "B", which costs $30.0
    And there is a "C", which costs $20.0
    And there is a "D", which costs $15.0
    And there is a pricing rule for "A", which costs $130.0 for 3 items
    And there is a pricing rule for "B", which costs $45.0 for 2 items
    When I scan the "A"
    And I scan the "B"
    And I scan the "C"
    And I scan the "A"
    And I scan the "B"
    And I scan the "D"
    And I scan the "A"
    And I scan the "C"
    Then the total should be $230.0

  Scenario: Scan item "A" two times with special offers - Buy 2 "A"'s for $90.0 and Buy 3 "A"'s for $130.0
    Given there is a "A", which costs $50.0
    And there is a pricing rule for "A", which costs $90.0 for 2 items
    And there is a pricing rule for "A", which costs $130.0 for 3 items
    When I scan the "A"
    And I scan the "A"
    Then the total should be $90.0

  Scenario: Scan item "A" three times with special offers - Buy 2 "A"'s for $90.0 and Buy 3 "A"'s for $130.0
    Given there is a "A", which costs $50.0
    And there is a pricing rule for "A", which costs $90.0 for 2 items
    And there is a pricing rule for "A", which costs $130.0 for 3 items
    When I scan the "A"
    And I scan the "A"
    And I scan the "A"
    Then the total should be $130.0
