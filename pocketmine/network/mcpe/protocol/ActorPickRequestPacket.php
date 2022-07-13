<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

use pocketmine\utils\Binary;

use pocketmine\network\mcpe\NetworkSession;

class ActorPickRequestPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::ACTOR_PICK_REQUEST_PACKET;

	/** @var int */
	public $entityUniqueId;
	/** @var int */
	public $hotbarSlot;
	/** @var bool */
	public $addUserData;

	protected function decodePayload(){
		$this->entityUniqueId = (Binary::readLLong($this->get(8)));
		$this->hotbarSlot = (\ord($this->get(1)));
		$this->addUserData = (($this->get(1) !== "\x00"));
	}

	protected function encodePayload(){
		($this->buffer .= (\pack("VV", $this->entityUniqueId & 0xFFFFFFFF, $this->entityUniqueId >> 32)));
		($this->buffer .= \chr($this->hotbarSlot));
		($this->buffer .= ($this->addUserData ? "\x01" : "\x00"));
	}

	public function handle(NetworkSession $session) : bool{
		return $session->handleActorPickRequest($this);
	}
}