<?php
/**
 * Resolve PolicyTemplates to their PolicyTemplateGroups
 *
 * @package modx
 * @subpackage build
 */
$success= false;

/* map of Template -> TemplateGroup */
$map = array(
    'ResourceTemplate' => 'Object',
    'AdministratorTemplate' => 'Admin',
    'ObjectTemplate' => 'Admin',
    'ElementTemplate' => 'Object',
);

$templates = $transport->xpdo->getCollection('modAccessPolicyTemplate');
foreach ($templates as $template) {
    $pk = isset($map[$template->get('name')]) ? $map[$template->get('name')] : 'Admin';
    $templateGroup = $transport->xpdo->getObject('modAccessPolicyTemplateGroup',array('name' => $pk));
    if ($templateGroup) {
        $template->set('template_group',$templateGroup->get('id'));
        $success = $template->save();
    }
}
return $success;