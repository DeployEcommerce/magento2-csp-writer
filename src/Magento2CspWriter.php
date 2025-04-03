<?php

namespace DeployEcommerce\Csp\Writer;

use SimpleXMLElement;

/**
 *
 */
class Magento2CspWriter
{

    /**
     * The initial XML we'll use to create an XML document.
     */
    const XML_HEADER = '<?xml version="1.0" encoding="utf-8" ?><csp_whitelist xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
               xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Csp:etc/csp_whitelist.xsd" />';

    /*
     * The closing XML tag for the document.
     */
    const XML_FOOTER = '</xml>';

    /**
     * The element we'll use to contain the CSP policies.
     */
    const ELEMENT_POLICIES = 'policies';

    /**
     * A single policy element which in turn is a single CSP directive.
     */
    const ELEMENT_POLICY = 'policy';

    /**
     * The element that contains the values for a policy.
     */
    const ELEMENT_VALUES = 'values';

    /**
     * A single value element which is a single CSP policy value.
     */
    const ELEMENT_VALUE = 'value';

    /**
     * Generate a Magento compatible CSP whitelist XML document.
     *
     * @param array $policies
     * @return string
     */
    public function generate(array $policies): string
    {
        $xml = new SimpleXMLElement(self::XML_HEADER);
        $xml_policies = $xml->addChild(self::ELEMENT_POLICIES);

        foreach ($policies as $directive => $policy) {
            $xml_policy = $xml_policies->addChild(self::ELEMENT_POLICY);
            $xml_policy->addAttribute('id', $directive);

            $values = $xml_policy->addChild(self::ELEMENT_VALUES);

            foreach ($policy as $policy_values) {
                $value = $values->addChild(self::ELEMENT_VALUE);
                $value->addAttribute('id', $policy_values['name']);
                $value->addAttribute('type', $policy_values['type']);
                $value[0] = $policy_values['value'];
            }
        }

        return $xml->asXML().self::XML_FOOTER;
    }
}
