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

class PhotoInfoRequestPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::PHOTO_INFO_REQUEST_PACKET;

	private int $photoId;

	public static function create(int $photoId) : self{
		$result = new self;
		$result->photoId = $photoId;
		return $result;
	}

	protected function decodePayload() : void{
		$this->photoId = $this->getEntityUniqueId();
	}

	protected function encodePayload() : void{
		$this->putEntityUniqueId($this->photoId);
	}

	public function handle(NetworkSession $handler) : bool{
		return $handler->handlePhotoInfoRequest($this);
	}
}
