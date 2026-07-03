# Contexto: Formulario/Publico

## Proposito

Permite que un trabajador registre su ficha de datos generales desde la ruta publica `/`.
El flujo recopila datos personales, contacto, datos laborales, familiares y confirmacion antes del envio final.

## Actores y permisos

- Trabajador o personal de la institucion: registra una ficha sin autenticacion.
- Backend publico: valida, normaliza y persiste la ficha.
- Administrador: consulta y edita fichas desde modulos admin, no desde este flujo.

## Entidades y relaciones relevantes

- `EmployeeForm`: ficha principal.
- `EmployeeFormFamilyMember`: familiares asociados a la ficha.
- Catalogos: `Sex`, `MaritalStatus`, `LaborRegime`, `PensionRegime`, `FamilyRelationship`, `Dependency`.
- `Legajo`: relacion posterior, creada solo desde admin.

## Estados y transiciones

- `form.currentStep`: `1 -> 2 -> 3 -> 4 -> 5`.
- `EmployeeForm.status`: se crea como `submitted`.
- `submitSuccess`: cambia a verdadero cuando el backend confirma el registro.

## Reglas de negocio

1. El DNI de la ficha debe tener 8 digitos y ser unico.
2. El RUC, si se informa, debe tener 11 digitos.
3. `conadis_rui` es obligatorio cuando `has_disability` es verdadero.
4. `labor_end_date` es obligatorio cuando `has_labor_link` es falso.
5. Si `is_parent` es verdadero, debe existir al menos un familiar.
6. Cada familiar requiere nombre completo, edad, sexo y parentesco; el DNI del familiar es opcional pero si existe debe tener 8 digitos.
7. El frontend valida por pasos, pero el backend es la fuente de verdad.
8. Los textos string de `EmployeeForm` se convierten a mayusculas al crear o actualizar.

## Endpoints / backend involucrado

- `GET /api/catalogs` -> devuelve catalogos activos y base del formulario.
- `POST /api/employee-forms/check-dni` -> indica si un DNI ya existe.
- `POST /api/employee-forms` -> registra ficha y familiares en transaccion.

## Flujo de datos

1. `HomeView.vue` carga catalogos desde `catalogStore`.
2. `formStore` mantiene el formulario, paso actual, errores y estados de envio.
3. Al pasar del paso 1 se valida disponibilidad de DNI.
4. Al enviar se normalizan IDs numericos y familiares.
5. Laravel valida con `StoreEmployeeFormRequest` y crea ficha con familiares dentro de `DB::transaction`.

## UI y rutas

- Ruta: `/`
- Vista: `frontend-formdatos/src/views/HomeView.vue`
- Store: `frontend-formdatos/src/stores/formStore.js`
- Servicios: `frontend-formdatos/src/services/formService.js`, `catalogService.js`
- Componentes principales: `FormStepper.vue`, `FormSectionCard.vue`, `StepPersonalData.vue`, `StepContactData.vue`, `StepLaborData.vue`, `StepFamilyData.vue`, `StepConfirmation.vue`, `SuccessState.vue`

## Errores esperables

- `422`: errores de validacion; el frontend mapea errores al paso correspondiente.
- Error de verificacion DNI: el frontend muestra mensaje para intentar nuevamente.
- Error inesperado de envio: mostrar mensaje general sin perder datos del formulario.

## Pruebas manuales minimas

1. Abrir `/` y verificar carga de catalogos.
2. Intentar avanzar con campos obligatorios vacios.
3. Registrar DNI invalido y DNI ya existente.
4. Registrar discapacidad sin CONADIS RUI y validar bloqueo.
5. Marcar sin vinculo laboral sin fecha de fin y validar bloqueo.
6. Marcar padre/madre sin familiares y validar bloqueo.
7. Enviar ficha valida y confirmar estado de exito.

## Cambios recientes

- El historial reciente indica mejoras de mayusculas, exportacion Excel, filtros y ficha.
