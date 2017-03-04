<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\enterprise\modules\spacetype\widgets;

use Yii;
use humhub\modules\space\models\Membership;

class Chooser extends \humhub\modules\space\widgets\Chooser
{
    
    private $spaceTypes;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->spaceTypes = \humhub\modules\enterprise\modules\spacetype\models\Type::find()->orderBy(['sort_key' => SORT_ASC])->all();
    }

    /**
     * Displays / Run the Widgets
     */
    public function run()
    {
        if (Yii::$app->user->isGuest) {
            return;
        }
        
        $memberships = $this->getMembershipQuery()->all();

        $typeMembershipMap = [];

        foreach ($this->spaceTypes as $spaceType) {

            $typeMembershipMap[$spaceType->id] = [
                'spaceType' => $spaceType,
                'memberships' => [],
            ];

            foreach ($memberships as $membership) {

                if ($membership->space->space_type_id == $spaceType->id) {
                    $typeMembershipMap[$spaceType->id]['memberships'][] = $membership;
                }
            }
        }

        return $this->render('spaceChooser', [
                    'currentSpace' => $this->getCurrentSpace(),
                    'spaceTypes' => $this->spaceTypes,
                    'createSpaceTypes' => $this->getCreateSpaceTypes(),
                    'memberships' => $this->getMemberships(),
                    'followSpaces' => $this->getFollowSpaces(),
                    'typeMembershipMap' => $typeMembershipMap,
        ]);
    }

    /**
     * Returns the membership query
     * 
     * @deprecated since version 1.2
     * @return type
     */
    protected function getMembershipQuery()
    {
        $query = Membership::find();

        if (Yii::$app->getModule('space')->settings->get('spaceOrder') == 0) {
            $query->orderBy('name ASC');
        } else {
            $query->orderBy('last_visit DESC');
        }

        $query->joinWith('space');
        $query->where(['space_membership.user_id' => Yii::$app->user->id, 'space_membership.status' => Membership::STATUS_MEMBER]);

        return $query;
    }

    public function getCreateSpaceTypes()
    {
        $types = [];

        if (!$this->canCreateSpace()) {
            return [];
        }

        foreach ($this->spaceTypes as $type) {
            if ($type->canCreateSpace()) {
                $types[] = $type;
            }
        }

        return $types;
    }

}
