import { defineStore } from 'pinia'
import { ref } from 'vue'
import { checkDniExists, submitEmployeeForm } from '../services/formService'

export const useFormStore = defineStore('form', () => {
    const currentStep = ref(1)

    const steps = ref([
        { id: 1, label: 'Datos personales' },
        { id: 2, label: 'Domicilio y contacto' },
        { id: 3, label: 'Datos laborales' },
        { id: 4, label: 'Datos familiares' },
        { id: 5, label: 'Confirmación' },
    ])

    const form = ref({
        full_name: '',
        dni: '',
        ruc: '',
        sex_id: '',
        marital_status_id: '',
        birth_date: '',
        birth_place: '',
        has_disability: false,
        conadis_rui: '',
        address: '',
        reference: '',
        district: '',
        province: '',
        department: '',
        cellphone: '',
        personal_email: '',
        emergency_contact_name: '',
        emergency_contact_phone: '',
        profession: '',
        current_position: '',
        current_dependency: '',
        contract_resolution_number: '',
        employment_start_date: '',
        labor_regime_id: '',
        labor_condition: '',
        pension_regime_id: '',
        airshsp_code: '',
        institutional_email: '',
        has_labor_link: true,
        labor_end_date: '',
        is_parent: false,
        family_members: [],
    })

    const errors = ref({})
    const submitting = ref(false)
    const checkingDni = ref(false)
    const submitSuccess = ref(false)
    const submitMessage = ref('')
    const submitError = ref('')

    const clearErrors = () => {
        errors.value = {}
    }

    const clearSubmitState = () => {
        submitSuccess.value = false
        submitMessage.value = ''
        submitError.value = ''
    }

    const setError = (field, message) => {
        errors.value[field] = message
    }

    const isEmailValid = (value) => {
        if (!value) return false
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)
    }

    const validateDniUniqueness = async () => {
        if (!form.value.dni || !/^\d{8}$/.test(form.value.dni)) {
            return false
        }

        checkingDni.value = true

        try {
            const response = await checkDniExists(form.value.dni)

            if (response?.data?.exists) {
                setError('dni', 'Ya existe una ficha registrada con este DNI.')
                return false
            }

            return true
        } catch (error) {
            setError('dni', 'No se pudo validar el DNI en este momento. Intente nuevamente.')
            return false
        } finally {
            checkingDni.value = false
        }
    }

    const validateStep1 = () => {
        clearErrors()

        if (!form.value.full_name?.trim()) {
            setError('full_name', 'El campo apellidos y nombres es obligatorio.')
        }

        if (!form.value.dni?.trim()) {
            setError('dni', 'El DNI es obligatorio.')
        } else if (!/^\d{8}$/.test(form.value.dni)) {
            setError('dni', 'El DNI debe tener exactamente 8 dígitos.')
        }

        if (form.value.ruc && !/^\d{11}$/.test(form.value.ruc)) {
            setError('ruc', 'El RUC debe tener exactamente 11 dígitos.')
        }

        if (!form.value.sex_id) {
            setError('sex_id', 'Debe seleccionar el sexo.')
        }

        if (!form.value.marital_status_id) {
            setError('marital_status_id', 'Debe seleccionar el estado civil.')
        }

        if (!form.value.birth_date) {
            setError('birth_date', 'La fecha de nacimiento es obligatoria.')
        }

        if (!form.value.birth_place?.trim()) {
            setError('birth_place', 'El lugar de nacimiento es obligatorio.')
        }

        if (form.value.has_disability === '' || form.value.has_disability === null) {
            setError('has_disability', 'Debe indicar si tiene discapacidad.')
        }

        if (form.value.has_disability === true && !form.value.conadis_rui?.trim()) {
            setError('conadis_rui', 'El CONADIS RUI es obligatorio cuando indica que sí tiene discapacidad.')
        }

        return Object.keys(errors.value).length === 0
    }

    const validateStep2 = () => {
        clearErrors()

        if (!form.value.address?.trim()) {
            setError('address', 'La dirección actual es obligatoria.')
        }

        if (!form.value.district?.trim()) {
            setError('district', 'El distrito es obligatorio.')
        }

        if (!form.value.province?.trim()) {
            setError('province', 'La provincia es obligatoria.')
        }

        if (!form.value.department?.trim()) {
            setError('department', 'El departamento es obligatorio.')
        }

        if (!form.value.cellphone?.trim()) {
            setError('cellphone', 'El celular es obligatorio.')
        }

        if (!form.value.personal_email?.trim()) {
            setError('personal_email', 'El correo personal es obligatorio.')
        } else if (!isEmailValid(form.value.personal_email)) {
            setError('personal_email', 'El correo personal no tiene un formato válido.')
        }

        if (!form.value.emergency_contact_name?.trim()) {
            setError('emergency_contact_name', 'El contacto de emergencia es obligatorio.')
        }

        if (!form.value.emergency_contact_phone?.trim()) {
            setError('emergency_contact_phone', 'El celular del contacto de emergencia es obligatorio.')
        }

        return Object.keys(errors.value).length === 0
    }

    const validateStep3 = () => {
        clearErrors()

        if (!form.value.profession?.trim()) {
            setError('profession', 'La profesión es obligatoria.')
        }

        if (!form.value.current_position?.trim()) {
            setError('current_position', 'El cargo actual es obligatorio.')
        }

        if (!form.value.current_dependency?.trim()) {
            setError('current_dependency', 'La dependencia actual es obligatoria.')
        }

        if (!form.value.contract_resolution_number?.trim()) {
            setError('contract_resolution_number', 'El contrato o resolución es obligatorio.')
        }

        if (!form.value.employment_start_date) {
            setError('employment_start_date', 'La fecha de vínculo es obligatoria.')
        }

        if (!form.value.labor_regime_id) {
            setError('labor_regime_id', 'Debe seleccionar el régimen laboral.')
        }

        if (!form.value.pension_regime_id) {
            setError('pension_regime_id', 'Debe seleccionar el régimen pensionario.')
        }

        if (form.value.institutional_email && !isEmailValid(form.value.institutional_email)) {
            setError('institutional_email', 'El correo institucional no tiene un formato válido.')
        }

        if (form.value.has_labor_link === '' || form.value.has_labor_link === null) {
            setError('has_labor_link', 'Debe indicar si tiene vínculo laboral.')
        }

        if (form.value.has_labor_link === false && !form.value.labor_end_date) {
            setError('labor_end_date', 'La fecha de fin de vínculo es obligatoria cuando indica que no tiene vínculo laboral.')
        }

        return Object.keys(errors.value).length === 0
    }

    const validateStep4 = () => {
        clearErrors()

        if (form.value.is_parent === '' || form.value.is_parent === null) {
            setError('is_parent', 'Debe indicar si es padre o madre de familia.')
        }

        if (form.value.is_parent === true) {
            if (!Array.isArray(form.value.family_members) || form.value.family_members.length === 0) {
                setError('family_members', 'Debe registrar al menos un familiar cuando indica que es padre o madre de familia.')
            } else {
                form.value.family_members.forEach((member, index) => {
                    if (!member.full_name?.trim()) {
                        setError(`family_members.${index}.full_name`, 'El nombre completo del familiar es obligatorio.')
                    }

                    if (member.dni && !/^\d{8}$/.test(member.dni)) {
                        setError(`family_members.${index}.dni`, 'El DNI del familiar debe tener exactamente 8 dígitos.')
                    }

                    if (member.age === '' || member.age === null) {
                        setError(`family_members.${index}.age`, 'La edad del familiar es obligatoria.')
                    }

                    if (!member.sex_id) {
                        setError(`family_members.${index}.sex_id`, 'Debe seleccionar el sexo del familiar.')
                    }

                    if (!member.relationship_id) {
                        setError(`family_members.${index}.relationship_id`, 'Debe seleccionar el parentesco del familiar.')
                    }
                })
            }
        }

        return Object.keys(errors.value).length === 0
    }

    const validateStep = (step = currentStep.value) => {
        if (step === 1) return validateStep1()
        if (step === 2) return validateStep2()
        if (step === 3) return validateStep3()
        if (step === 4) return validateStep4()

        clearErrors()
        return true
    }

    const validateAllStepsBeforeSubmit = () => {
        clearErrors()

        let isValid = true

        const tempSetError = (field, message) => {
            errors.value[field] = message
            isValid = false
        }

        if (!form.value.full_name?.trim()) {
            tempSetError('full_name', 'El campo apellidos y nombres es obligatorio.')
        }

        if (!form.value.dni?.trim()) {
            tempSetError('dni', 'El DNI es obligatorio.')
        } else if (!/^\d{8}$/.test(form.value.dni)) {
            tempSetError('dni', 'El DNI debe tener exactamente 8 dígitos.')
        }

        if (form.value.ruc && !/^\d{11}$/.test(form.value.ruc)) {
            tempSetError('ruc', 'El RUC debe tener exactamente 11 dígitos.')
        }

        if (!form.value.sex_id) {
            tempSetError('sex_id', 'Debe seleccionar el sexo.')
        }

        if (!form.value.marital_status_id) {
            tempSetError('marital_status_id', 'Debe seleccionar el estado civil.')
        }

        if (!form.value.birth_date) {
            tempSetError('birth_date', 'La fecha de nacimiento es obligatoria.')
        }

        if (!form.value.birth_place?.trim()) {
            tempSetError('birth_place', 'El lugar de nacimiento es obligatorio.')
        }

        if (form.value.has_disability === true && !form.value.conadis_rui?.trim()) {
            tempSetError('conadis_rui', 'El CONADIS RUI es obligatorio cuando indica que sí tiene discapacidad.')
        }

        if (!form.value.address?.trim()) {
            tempSetError('address', 'La dirección actual es obligatoria.')
        }

        if (!form.value.district?.trim()) {
            tempSetError('district', 'El distrito es obligatorio.')
        }

        if (!form.value.province?.trim()) {
            tempSetError('province', 'La provincia es obligatoria.')
        }

        if (!form.value.department?.trim()) {
            tempSetError('department', 'El departamento es obligatorio.')
        }

        if (!form.value.cellphone?.trim()) {
            tempSetError('cellphone', 'El celular es obligatorio.')
        }

        if (!form.value.personal_email?.trim()) {
            tempSetError('personal_email', 'El correo personal es obligatorio.')
        } else if (!isEmailValid(form.value.personal_email)) {
            tempSetError('personal_email', 'El correo personal no tiene un formato válido.')
        }

        if (!form.value.emergency_contact_name?.trim()) {
            tempSetError('emergency_contact_name', 'El contacto de emergencia es obligatorio.')
        }

        if (!form.value.emergency_contact_phone?.trim()) {
            tempSetError('emergency_contact_phone', 'El celular del contacto de emergencia es obligatorio.')
        }

        if (!form.value.profession?.trim()) {
            tempSetError('profession', 'La profesión es obligatoria.')
        }

        if (!form.value.current_position?.trim()) {
            tempSetError('current_position', 'El cargo actual es obligatorio.')
        }

        if (!form.value.current_dependency?.trim()) {
            tempSetError('current_dependency', 'La dependencia actual es obligatoria.')
        }

        if (!form.value.contract_resolution_number?.trim()) {
            tempSetError('contract_resolution_number', 'El contrato o resolución es obligatorio.')
        }

        if (!form.value.employment_start_date) {
            tempSetError('employment_start_date', 'La fecha de vínculo es obligatoria.')
        }

        if (!form.value.labor_regime_id) {
            tempSetError('labor_regime_id', 'Debe seleccionar el régimen laboral.')
        }

        if (!form.value.pension_regime_id) {
            tempSetError('pension_regime_id', 'Debe seleccionar el régimen pensionario.')
        }

        if (form.value.institutional_email && !isEmailValid(form.value.institutional_email)) {
            tempSetError('institutional_email', 'El correo institucional no tiene un formato válido.')
        }

        if (form.value.has_labor_link === false && !form.value.labor_end_date) {
            tempSetError('labor_end_date', 'La fecha de fin de vínculo es obligatoria cuando indica que no tiene vínculo laboral.')
        }

        if (form.value.is_parent === true) {
            if (!Array.isArray(form.value.family_members) || form.value.family_members.length === 0) {
                tempSetError('family_members', 'Debe registrar al menos un familiar cuando indica que es padre o madre de familia.')
            } else {
                form.value.family_members.forEach((member, index) => {
                    if (!member.full_name?.trim()) {
                        tempSetError(`family_members.${index}.full_name`, 'El nombre completo del familiar es obligatorio.')
                    }

                    if (member.dni && !/^\d{8}$/.test(member.dni)) {
                        tempSetError(`family_members.${index}.dni`, 'El DNI del familiar debe tener exactamente 8 dígitos.')
                    }

                    if (member.age === '' || member.age === null) {
                        tempSetError(`family_members.${index}.age`, 'La edad del familiar es obligatoria.')
                    }

                    if (!member.sex_id) {
                        tempSetError(`family_members.${index}.sex_id`, 'Debe seleccionar el sexo del familiar.')
                    }

                    if (!member.relationship_id) {
                        tempSetError(`family_members.${index}.relationship_id`, 'Debe seleccionar el parentesco del familiar.')
                    }
                })
            }
        }

        return isValid
    }

    const nextStep = async () => {
        const isValid = validateStep(currentStep.value)

        if (!isValid) return false

        if (currentStep.value === 1) {
            const isDniAvailable = await validateDniUniqueness()

            if (!isDniAvailable) return false
        }

        if (currentStep.value < steps.value.length) {
            currentStep.value++
        }

        return true
    }

    const previousStep = () => {
        clearErrors()

        if (currentStep.value > 1) {
            currentStep.value--
        }
    }

    const normalizePayload = () => {
        return {
            ...form.value,
            sex_id: form.value.sex_id ? Number(form.value.sex_id) : null,
            marital_status_id: form.value.marital_status_id ? Number(form.value.marital_status_id) : null,
            labor_regime_id: form.value.labor_regime_id ? Number(form.value.labor_regime_id) : null,
            pension_regime_id: form.value.pension_regime_id ? Number(form.value.pension_regime_id) : null,
            family_members: form.value.family_members.map((member) => ({
                ...member,
                age: member.age !== '' ? Number(member.age) : null,
                sex_id: member.sex_id ? Number(member.sex_id) : null,
                relationship_id: member.relationship_id ? Number(member.relationship_id) : null,
            })),
        }
    }

    const resetForm = () => {
        form.value = {
            full_name: '',
            dni: '',
            ruc: '',
            sex_id: '',
            marital_status_id: '',
            birth_date: '',
            birth_place: '',
            has_disability: false,
            conadis_rui: '',
            address: '',
            reference: '',
            district: '',
            province: '',
            department: '',
            cellphone: '',
            personal_email: '',
            emergency_contact_name: '',
            emergency_contact_phone: '',
            profession: '',
            current_position: '',
            current_dependency: '',
            contract_resolution_number: '',
            employment_start_date: '',
            labor_regime_id: '',
            labor_condition: '',
            pension_regime_id: '',
            airshsp_code: '',
            institutional_email: '',
            has_labor_link: true,
            labor_end_date: '',
            is_parent: false,
            family_members: [],
        }

        currentStep.value = 1
        clearErrors()
        clearSubmitState()
    }

    const submitForm = async () => {
        clearSubmitState()
        clearErrors()

        const isValid = validateAllStepsBeforeSubmit()

        if (!isValid) {
            submitError.value = 'Revise los datos ingresados antes de enviar el formulario.'
            return { success: false }
        }

        submitting.value = true

        try {
            const payload = normalizePayload()
            const response = await submitEmployeeForm(payload)

            submitSuccess.value = true
            submitMessage.value = response.message || 'La ficha fue registrada correctamente.'

            return { success: true, data: response.data }
        } catch (error) {
            if (error?.response?.status === 422) {
                const backendErrors = error.response.data.errors || {}

                Object.entries(backendErrors).forEach(([field, messages]) => {
                    errors.value[field] = Array.isArray(messages) ? messages[0] : messages
                })

                if (
                    backendErrors.full_name ||
                    backendErrors.dni ||
                    backendErrors.ruc ||
                    backendErrors.sex_id ||
                    backendErrors.marital_status_id ||
                    backendErrors.birth_date ||
                    backendErrors.birth_place ||
                    backendErrors.has_disability ||
                    backendErrors.conadis_rui
                ) {
                    currentStep.value = 1
                } else if (
                    backendErrors.address ||
                    backendErrors.reference ||
                    backendErrors.district ||
                    backendErrors.province ||
                    backendErrors.department ||
                    backendErrors.cellphone ||
                    backendErrors.personal_email ||
                    backendErrors.emergency_contact_name ||
                    backendErrors.emergency_contact_phone
                ) {
                    currentStep.value = 2
                } else if (
                    backendErrors.profession ||
                    backendErrors.current_position ||
                    backendErrors.current_dependency ||
                    backendErrors.contract_resolution_number ||
                    backendErrors.employment_start_date ||
                    backendErrors.labor_regime_id ||
                    backendErrors.labor_condition ||
                    backendErrors.pension_regime_id ||
                    backendErrors.airshsp_code ||
                    backendErrors.institutional_email ||
                    backendErrors.has_labor_link ||
                    backendErrors.labor_end_date
                ) {
                    currentStep.value = 3
                } else if (
                    backendErrors.is_parent ||
                    backendErrors.family_members ||
                    Object.keys(backendErrors).some((key) => key.startsWith('family_members.'))
                ) {
                    currentStep.value = 4
                }

                submitError.value = 'Se encontraron errores de validación. Revise la información registrada.'
            } else {
                submitError.value =
                    error?.response?.data?.message ||
                    'Ocurrió un error inesperado al enviar el formulario.'
            }

            return { success: false }
        } finally {
            submitting.value = false
        }
    }

    return {
        currentStep,
        steps,
        form,
        errors,
        checkingDni,
        submitting,
        submitSuccess,
        submitMessage,
        submitError,
        clearErrors,
        clearSubmitState,
        validateStep,
        nextStep,
        previousStep,
        submitForm,
        resetForm,
        validateDniUniqueness,
    }
})