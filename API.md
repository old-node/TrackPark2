# TrackPark API v2

## Athlete

Données sur les athlètes

**URL** : `/v2/athlete.php`

**Options**
- `?coach=<id>` - Athlètes ayant le coach spécifier (id)
- `?id=<id>` - Athlète ayant l'ID spécifié
- `?group=<group id>` - Athlètes fesant parties d'un groupe

## Athlete Category

Données sur les catégories d'athlètes

**URL** : `/v2/athlete_category.php`

**Options**
- `?id=<id>` - Catégorie ayant l'ID spécifié

## Cap

**URL** : `/v2/cap.php`

**Options**
- `?code=<code>` - cap ayant le code spécifié

## Coach

**URL** : `/v2/coach.php`

**Options**
- `?id=<id>` - coach ayant l'ID spécifié

## Course
**URL** : `/v2/course.php`

**Options**
- `?id=<id>` - course ayant l'ID spécifié

## Course type
**URL** : `/v2/course_type.php`

**Options**
- `?id=<id>` - course type ayant l'ID spécifié

## Dril
**URL** : `/v2/drill.php`

**Options**
- `?id=<id>` - drill ayant l'ID spécifié

## Dril type
**URL** : `/v2/drill_type.php`

**Options**
- `?id=<id>` - drill ayant l'ID spécifié

## Évaluation

### Fetch
**Method**: GET

**URL** : `/v2/evaluation.php`

**Options**
- `?id=<id>` - evaluation ayant l'ID spécifié
- `?athlete=id` - evaluation pour l'athlete
- `?coach=id` - evaluation pour un coach

### Update
**Method**: POST

**URL**: `/v2/evaluation.php`

**Body**
- "id" -> int, obligatoire
- "state" -> true ou false, optionel
- "numerical_value" -> int, optionel

Exemple
```json
{
    "id": (int),
    "state": [true|false],
    "numerical_value": [int]
}
```

## Group
**URL** : `/v2/group.php`

**Options**
- `?id=<id>` - group ayant l'ID spécifié
- `?coach=id` - group d'un coach

### Add right
**Method**: POST

**URL**: `/v2/group.php`

**Body**
- "action" -> string, obligatoire, "addRight"
- "group" -> int, obligatoire
- "coach" -> int, obligatoire
- "type" -> int, obligatoire

Exemple
```json
{
    "action": "addRight",
    "group": (int),
    "coach": (int),
    "type": (int)
}
```