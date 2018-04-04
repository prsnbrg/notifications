<?php
/**
 * ownCloud
 *
 * @author Artur Neumann <artur@jankaritech.com>
 * @copyright Copyright (c) 2018 Artur Neumann artur@jankaritech.com
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License,
 * as published by the Free Software Foundation;
 * either version 3 of the License, or any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace Page;

use Behat\Mink\Session;
use Behat\Mink\Element\NodeElement;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;

/**
 * PageObject for a single notification
 */
class Notification extends OwncloudPage {
	
	/**
	 * 
	 * @var NodeElement
	 */
	protected $notificationElement;
	
	protected $buttonByTextXpath = "//button[text()='%s']";

	/**
	 * sets the NodeElement for the current notification
	 * a little bit like __construct() but as we access this "sub-page-object"
	 * from an other Page Object by $this->getPage("Notification")
	 * there is no real __construct() that can take arguments
	 *
	 * @param \Behat\Mink\Element\NodeElement $notificationElement
	 *
	 * @return void
	 */
	public function setElement(NodeElement $notificationElement) {
		$this->notificationElement = $notificationElement;
	}

	/**
	 * 
	 * @param string $reaction
	 * @param Session $session
	 * 
	 * @return void
	 */
	public function react($reaction, Session $session) {
		$buttonXpath = sprintf($this->buttonByTextXpath, $reaction);
		$button = $this->notificationElement->find(
			"xpath", $buttonXpath
		);
		if (is_null($button)) {
			throw new ElementNotFoundException(
				__METHOD__ .
				" xpath " . $buttonXpath . 
				" could not find button with the given text"
			);
		}
		$button->click();
		$this->waitForAjaxCallsToStartAndFinish($session);
	}
}