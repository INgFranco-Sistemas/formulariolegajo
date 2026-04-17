const fs = require("fs");

const data = require("../public/data/ubigeo-peru.json");

const result = {};

data.forEach((item) => {
    const depCode = item.ubigeo.substring(0, 2);
    const provCode = item.ubigeo.substring(0, 4);
    const distCode = item.ubigeo;

    if (!result[depCode]) {
        result[depCode] = {
            code: depCode,
            name: item.departamento,
            provinces: {},
        };
    }

    if (!result[depCode].provinces[provCode]) {
        result[depCode].provinces[provCode] = {
            code: provCode,
            name: item.provincia,
            districts: [],
        };
    }

    result[depCode].provinces[provCode].districts.push({
        code: distCode,
        name: item.distrito,
    });
});

const finalData = Object.values(result).map((dep) => ({
    ...dep,
    provinces: Object.values(dep.provinces),
}));

fs.writeFileSync(
    "./public/data/ubigeo-peru-anidado.json",
    JSON.stringify(finalData, null, 2),
);

console.log("✅ JSON anidado generado");
