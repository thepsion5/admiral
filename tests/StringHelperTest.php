<?php
namespace Thepsion5\Admiral\Testing;

use Thepsion5\Admiral\StringHelper;

class StringHelperTest extends TestCase
{

    protected $patterns = ['Something.*', 'Something.Else.*', 'Something.Else.Entirely'];

    protected $values = ['Something.A.B', 'Something.Else.A.B', 'Something.Else.Entirely', 'Other'];

    private function matchValues($pattern)
    {
        return [
            StringHelper::matchesWildcard($pattern, $this->values[0]),
            StringHelper::matchesWildcard($pattern, $this->values[1]),
            StringHelper::matchesWildcard($pattern, $this->values[2]),
            StringHelper::matchesWildcard($pattern, $this->values[3])
        ];
    }

    /** @test */
    public function it_matches_a_string_with_no_wildcard_if_they_are_equal()
    {
        $expectedResults = [false, false, true, false];

        $actualResults = $this->matchValues($this->patterns[2]);

        $this->assertEquals($expectedResults, $actualResults);
    }

    /** @test */
    public function it_matches_a_string_with_a_wildcard()
    {
        $expectedResults = [true, true, true, false];

        $actualResults = $this->matchValues($this->patterns[0]);

        $this->assertEquals($expectedResults, $actualResults);
    }

    /** @test */
    public function it_does_not_count_a_partial_match_unless_the_pattern_ends_with_a_wildcard()
    {
        $expectedResults = [false, true, true, false];

        $actualResults = $this->matchValues($this->patterns[1]);

        $this->assertEquals($expectedResults, $actualResults);
    }

    /** @test */
    public function it_converts_a_class_to_dot_notation()
    {
        $classNamesToConvert = array(
            'Classname',
            'ClassName',
            'Class\\Name',
            '\\Another\\Class\\Name'
        );

        $expectedResults = array(
            'classname',
            'class_name',
            'class.name',
            'another.class.name'
        );

        $results = array(
            StringHelper::classToDotNotation($classNamesToConvert[0]),
            StringHelper::classToDotNotation($classNamesToConvert[1]),
            StringHelper::classToDotNotation($classNamesToConvert[2]),
            StringHelper::classToDotNotation($classNamesToConvert[3])
        );

        $this->assertEquals($expectedResults, $results);
    }
}
