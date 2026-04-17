import { computed, ref } from 'vue'

const ubigeoData = ref([])
const ubigeoLoaded = ref(false)
const ubigeoLoading = ref(false)
const ubigeoError = ref('')

const normalizeText = (value) => {
  return String(value || '')
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .trim()
    .toLowerCase()
}

const loadUbigeo = async () => {
  if (ubigeoLoaded.value || ubigeoLoading.value) return

  ubigeoLoading.value = true
  ubigeoError.value = ''

  try {
    const response = await fetch('/data/ubigeo-peru-anidado.json')

    if (!response.ok) {
      throw new Error('No se pudo cargar el archivo de ubigeo.')
    }

    const text = await response.text()

    try {
      ubigeoData.value = JSON.parse(text)
    } catch {
      throw new Error('El archivo ubigeo-peru-anidado.json no tiene un formato JSON válido.')
    }

    ubigeoLoaded.value = true
  } catch (error) {
    ubigeoError.value = error.message || 'Error cargando ubigeo.'
  } finally {
    ubigeoLoading.value = false
  }
}

const findDepartmentByName = (departmentName) => {
  return ubigeoData.value.find(
    (department) => normalizeText(department.name) === normalizeText(departmentName)
  )
}

const findProvinceByName = (departmentName, provinceName) => {
  const department = findDepartmentByName(departmentName)
  if (!department) return null

  return department.provinces.find(
    (province) => normalizeText(province.name) === normalizeText(provinceName)
  )
}

const findDistrictByName = (departmentName, provinceName, districtName) => {
  const province = findProvinceByName(departmentName, provinceName)
  if (!province) return null

  return province.districts.find(
    (district) => normalizeText(district.name) === normalizeText(districtName)
  )
}

export const useUbigeo = (formRef) => {
  const departmentOptions = computed(() =>
    ubigeoData.value.map((department) => ({
      id: department.name,
      name: department.name,
      code: department.code,
    }))
  )

  const provinceOptions = computed(() => {
    const selectedDepartment = findDepartmentByName(formRef.value.department)

    if (!selectedDepartment) return []

    return selectedDepartment.provinces.map((province) => ({
      id: province.name,
      name: province.name,
      code: province.code,
    }))
  })

  const districtOptions = computed(() => {
    const selectedProvince = findProvinceByName(
      formRef.value.department,
      formRef.value.province
    )

    if (!selectedProvince) return []

    return selectedProvince.districts.map((district) => ({
      id: district.name,
      name: district.name,
      code: district.code,
    }))
  })

  const handleDepartmentChange = () => {
    formRef.value.province = ''
    formRef.value.district = ''
  }

  const handleProvinceChange = () => {
    formRef.value.district = ''
  }

  const syncUbigeoValues = () => {
    if (!formRef.value) return

    const matchedDepartment = findDepartmentByName(formRef.value.department)
    if (matchedDepartment) {
      formRef.value.department = matchedDepartment.name
    } else {
      formRef.value.department = ''
      formRef.value.province = ''
      formRef.value.district = ''
      return
    }

    const matchedProvince = findProvinceByName(
      formRef.value.department,
      formRef.value.province
    )

    if (matchedProvince) {
      formRef.value.province = matchedProvince.name
    } else {
      formRef.value.province = ''
      formRef.value.district = ''
      return
    }

    const matchedDistrict = findDistrictByName(
      formRef.value.department,
      formRef.value.province,
      formRef.value.district
    )

    if (matchedDistrict) {
      formRef.value.district = matchedDistrict.name
    } else {
      formRef.value.district = ''
    }
  }

  return {
    loadUbigeo,
    ubigeoLoaded,
    ubigeoLoading,
    ubigeoError,
    departmentOptions,
    provinceOptions,
    districtOptions,
    handleDepartmentChange,
    handleProvinceChange,
    syncUbigeoValues,
  }
}