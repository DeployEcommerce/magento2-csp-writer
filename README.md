# Magento 2 CSP Writer

This library is a simple CSP writer for Magento 2.

It can be used to write a `csp_whitelist.xml` file given a structured array.

The policies array should be in the format:

```
$policies = [
    'default-src' => [
        [
            'type' => 'host',
            'name' => 'example.com',
            'value' => 'https://example.com',
            'directive' => 'default-src',
        ],
        [
            'type' => 'host',
            'name' => '*.example.com',
            'value' => '*.example.com',
            'directive' => 'default-src',
        ],
    ],
];
```

Create a writer instance and call the `generate` method with the structured array:

```php
$writer = new DeployEcommerce\Csp\Writer\Magento2CspWriter();
$xml = $writer->generate($policies);
```
You'll then be returned the following XML to write to your `csp_whitelist.xml` file:

```
<?xml version="1.0" encoding="utf-8"?>
<csp_whitelist xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
               xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Csp:etc/csp_whitelist.xsd">
    <policies>
        <policy id="default-src">
            <values>
                <value id="example.com" type="host">https://example.com</value>
                <value id="*.example.com" type="host">*.example.com</value>
            </values>
        </policy>
    </policies>
</csp_whitelist>
```
This can be used in conjunction with the [DeployEcommerce/magento2-csp-parser](https://github.com/DeployEcommerce/magento2-csp-parser) 
package to parse an existing `csp_whitelist.xml` file and return you a structured array.