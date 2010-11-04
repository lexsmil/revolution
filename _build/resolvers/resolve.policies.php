<?php
/**
 * Resolve Policies to their PolicyTemplates
 */
$success= false;

/* map of Policy -> Template */
$map = array(
    'Resource' => 'ResourceTemplate',
    'Administrator' => 'AdministratorTemplate',
    'Load Only' => 'ObjectTemplate',
    'Load, List and View' => 'ObjectTemplate',
    'Object' => 'ObjectTemplate',
    'Element' => 'ElementTemplate',
);

$policies = $transport->xpdo->getCollection('modAccessPolicy');
foreach ($policies as $policy) {
    $pk = isset($map[$policy->get('name')]) ? $map[$policy->get('name')] : 'Administrator';
    $template = $transport->xpdo->getObject('modAccessPolicyTemplate',array('name' => $pk));
    if ($template) {
        $policy->set('template',$template->get('id'));
        $success = $policy->save();
    }
}
return $success;