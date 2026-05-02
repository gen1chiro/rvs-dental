document.addEventListener('DOMContentLoaded', () => {
    const steps = Array.from(document.querySelectorAll('.form-step'));
    const form = document.getElementById('medical-form');
    const prevBtn = document.getElementById('prev-step');
    const nextBtn = document.getElementById('next-step');
    const saveBtn = document.getElementById('save-form');
    const otherConditionCheckbox = document.querySelector('input[data-other-condition="true"]');
    const otherConditionNotesWrapper = document.getElementById('other-condition-notes-wrapper');
    const otherConditionNotesInput = document.getElementById('other-condition-notes');

    if (!steps.length || !prevBtn || !nextBtn || !saveBtn || !form) return;

    let currentStep = 1;
    const isFemale = form.dataset.isFemale === '1';

    const questionRules = {
        radioOnly: [1, 6, 7],
        radioWithNotes: [2, 3, 4, 5, 8],
        textOnly: [9, 13, 14],
        womenOnly: [10, 11, 12],
        bloodType: [13],
    };

    const hasCheckedRadio = (questionId) =>
        Boolean(form.querySelector(`input[name="responses[${questionId}][answer]"]:checked`));

    const getRadioAnswer = (questionId) =>
        form.querySelector(`input[name="responses[${questionId}][answer]"]:checked`)?.value;

    const getNotesValue = (questionId) =>
        form.querySelector(`input[name="responses[${questionId}][notes]"]`)?.value.trim() ?? '';

    const hasCheckedNotesRadio = (questionId) =>
        Boolean(form.querySelector(`input[name="responses[${questionId}][notes]"]:checked`));

    const validateRequiredInputs = () => {
        const requiredRadio = questionRules.radioOnly
            .concat(questionRules.radioWithNotes)
            .concat(isFemale ? questionRules.womenOnly : []);

        if (requiredRadio.some((questionId) => !hasCheckedRadio(questionId))) {
            return false;
        }

        const requiredTextOnly = questionRules.textOnly.filter(
            (questionId) => !questionRules.bloodType.includes(questionId)
        );

        if (requiredTextOnly.some((questionId) => getNotesValue(questionId) === '')) {
            return false;
        }

        if (questionRules.bloodType.some((questionId) => !hasCheckedNotesRadio(questionId))) {
            return false;
        }

        for (const questionId of questionRules.radioWithNotes) {
            if (getRadioAnswer(questionId) === 'Yes' && getNotesValue(questionId) === '') {
                return false;
            }
        }

        if (otherConditionCheckbox?.checked && otherConditionNotesInput?.value.trim() === '') {
            return false;
        }

        return true;
    };

    const updateSaveState = () => {
        saveBtn.disabled = !validateRequiredInputs();
    };

    const renderStep = () => {
        steps.forEach((step, index) => {
            const stepNumber = index + 1;
            step.classList.toggle('hidden', stepNumber !== currentStep);
        });

        if (currentStep === steps.length) {
            nextBtn.disabled = true;
            saveBtn.classList.remove('hidden');
        } else {
            nextBtn.disabled = false;
            saveBtn.classList.add('hidden');
        }

        prevBtn.disabled = currentStep === 1;
        updateSaveState();
    };

    prevBtn.addEventListener('click', () => {
        if (currentStep > 1) {
            currentStep -= 1;
            renderStep();
        }
    });

    nextBtn.addEventListener('click', () => {
        if (currentStep < steps.length) {
            currentStep += 1;
            renderStep();
        }
    });

    if (otherConditionCheckbox && otherConditionNotesWrapper) {
        const renderOtherConditionNotes = () => {
            const shouldShow = otherConditionCheckbox.checked;

            otherConditionNotesWrapper.classList.toggle('hidden', !shouldShow);

            if (otherConditionNotesInput) {
                otherConditionNotesInput.disabled = !shouldShow;
                if (!shouldShow) {
                    otherConditionNotesInput.value = '';
                }
            }
        };

        otherConditionCheckbox.addEventListener('change', renderOtherConditionNotes);
        renderOtherConditionNotes();
    }

    form.addEventListener('input', updateSaveState);
    form.addEventListener('change', updateSaveState);

    renderStep();
});
