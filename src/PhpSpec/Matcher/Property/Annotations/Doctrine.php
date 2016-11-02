<?php

namespace PhpSpec\Matcher\Property\Annotations;


use phpDocumentor\Reflection\DocBlock\Tag;
use PhpSpec\Exception\Fracture\AnnotationMissing;
use PhpSpec\Matcher\Matcher;
use PhpSpec\Matcher\MatcherInterface;
use PhpSpec\Matcher\Property\PropertyReflectionMatcher;

/**
 * Utility functions for dealing with doctrine property annotations
 * Abstract Class Doctrine
 * @package PhpSpec\Matcher\Property\Annotations\
 */
abstract class Doctrine implements MatcherInterface
{

    /**
     * @param \ReflectionProperty $subject
     * @param string $tagName
     * @return Tag
     * @throws AnnotationMissing
     * @throws \Exception
     */
    protected function getTagObject(\ReflectionProperty $subject, string $tagName) : Tag 
    {
        // allow tag to be passed as ORM\Column or just Column
        if ( substr($tagName, 0, 4) != 'ORM\\') {
            $agName = 'ORM\\' . ucfirst($tagName);
        }

        $docHandler = DocBlockFactory::createInstance()->create($subject);
        
        //check if tag really exists
        if (!$docHandler->hasTag($tagName))
            throw new AnnotationMissing(null, $subject, $tagName);

        // get the spcieied tag off the doc block
        $tags = $docHandler->getTagsByName($tagName);

        // account for > 1 tag returned
        if (is_array($tags))
            throw new \Exception('Found multiple annotations with name ' . $tagName );

        return $tags;
    }

    /**
     * Explode the annotation value ("key"="val", "name"="nick"...) into an assoc array
     * @param string $found
     * @return array
     */
    protected function getArgsAsArray(string $found) : array 
    {
        // break the original args into an array
        $found = preg_replace('/\(|\)/','', $found);

        $found = explode(',', $found);
        array_walk($found, 'trim');

        $res = [];

        foreach ( $found as $expr )
        {
            $expr = preg_replace('/"/','',$expr);
            $expr = explode('=', $expr);
            $res[trim($expr[0])] = trim($expr[1]);
        }
        
    }

    /**
     * Determine if the arguments from the tag matches the array supplied
     * @param string $found
     * @param array $expected
     * @return bool
     */
    public function isArgsMismatch(string $found, array $expected) : bool
    {
        // Make sure the annotation value matches the same arguments passed to the matching function
        $diff = array_diff_assoc($this->getArgsAsArray($found), $expected);
        
        return (count($diff) > 0) ? true : false;
    }

    /**
     * returns args in format ("key"="val","key2"="val2")
     * Left as public so the PHP builder can access it later
     * @param array $args
     * @return string
     */
/*
    public function buildArgs(array $args) : string
    {
        return '(' .
            implode(',', array_map(function ($key) use ($args){
                return "\"{$key}\"=\"{$args[$key]}\"";
            }, array_keys($args))) . ')';
    }
*/


}