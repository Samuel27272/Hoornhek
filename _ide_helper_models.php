<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $voornaam
 * @property string $achternaam
 * @property string|null $telefoonnummer
 * @property string|null $email
 * @property \Carbon\CarbonImmutable|null $start_bezoek
 * @property string $status
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @method static \Database\Factories\BezoekerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bezoeker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bezoeker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bezoeker query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bezoeker whereAchternaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bezoeker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bezoeker whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bezoeker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bezoeker whereStartBezoek($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bezoeker whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bezoeker whereTelefoonnummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bezoeker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bezoeker whereVoornaam($value)
 */
	class Bezoeker extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $cel_nummer
 * @property int $capaciteit
 * @property string $status
 * @property string|null $opmerkingen
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gedetineerde> $gedetineerden
 * @property-read int|null $gedetineerden_count
 * @method static \Database\Factories\CelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cel whereCapaciteit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cel whereCelNummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cel whereOpmerkingen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cel whereUpdatedAt($value)
 */
	class Cel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $gedetineerde_id
 * @property int|null $geupload_door
 * @property string $bestandsnaam
 * @property string $bestand_pad
 * @property string|null $mime_type
 * @property string $type
 * @property string|null $omschrijving
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Gedetineerde $gedetineerde
 * @property-read \App\Models\User|null $geuploadDoor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereBestandPad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereBestandsnaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereGedetineerdeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereGeuploadDoor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereOmschrijving($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereUpdatedAt($value)
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $bsn_nummer
 * @property string $voornaam
 * @property string $achternaam
 * @property \Carbon\CarbonImmutable $geboortedatum
 * @property string $straatnaam
 * @property string $huisnummer
 * @property string $postcode
 * @property string $woonplaats
 * @property string|null $telefoonnummer
 * @property string|null $email
 * @property string|null $foto_pad
 * @property \Carbon\CarbonImmutable $aanhoudingsdatum
 * @property \Carbon\CarbonImmutable|null $datum_schorsing
 * @property string $status
 * @property int|null $cel_id
 * @property string|null $opmerkingen
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Cel|null $cel
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documenten
 * @property-read int|null $documenten_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Historie> $historie
 * @property-read int|null $historie_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Zaak> $zaken
 * @property-read int|null $zaken_count
 * @method static \Database\Factories\GedetineerdeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereAanhoudingsdatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereAchternaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereBsnNummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereCelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereDatumSchorsing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereFotoPad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereGeboortedatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereHuisnummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereOpmerkingen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereStraatnaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereTelefoonnummer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereVoornaam($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gedetineerde whereWoonplaats($value)
 */
	class Gedetineerde extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $gedetineerde_id
 * @property int|null $uitgevoerd_door
 * @property string $gebeurtenis
 * @property int|null $cel_oud
 * @property int|null $cel_nieuw
 * @property string $type
 * @property string|null $opmerkingen
 * @property \Carbon\CarbonImmutable $datum
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Cel|null $celNieuw
 * @property-read \App\Models\Cel|null $celOud
 * @property-read \App\Models\Gedetineerde $gedetineerde
 * @property-read \App\Models\User|null $uitgevoerdDoor
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie whereCelNieuw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie whereCelOud($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie whereDatum($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie whereGebeurtenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie whereGedetineerdeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie whereOpmerkingen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie whereUitgevoerdDoor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Historie whereUpdatedAt($value)
 */
	class Historie extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $email
 * @property string $event
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LoginLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LoginLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LoginLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LoginLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LoginLog whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LoginLog whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LoginLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LoginLog whereUserId($value)
 */
	class LoginLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $group
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property int|null $role_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Zaak> $createdZaken
 * @property-read int|null $created_zaken_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $uploadedDocuments
 * @property-read int|null $uploaded_documents_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $zaaknummer
 * @property string $omschrijving
 * @property string|null $misdaad_type
 * @property string $status
 * @property \Carbon\CarbonImmutable $datum_aangemaakt
 * @property \Carbon\CarbonImmutable|null $datum_gesloten
 * @property string|null $opmerkingen
 * @property int|null $aangemaakt_door
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\User|null $aangemaaktDoor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gedetineerde> $gedetineerden
 * @property-read int|null $gedetineerden_count
 * @method static \Database\Factories\ZaakFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak whereAangemaaktDoor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak whereDatumAangemaakt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak whereDatumGesloten($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak whereMisdaadType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak whereOmschrijving($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak whereOpmerkingen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Zaak whereZaaknummer($value)
 */
	class Zaak extends \Eloquent {}
}

