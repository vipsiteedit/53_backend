<div class="blockLicense">
    <if:[param55]=='Y'>
        <div class="license-item">
            <label>
                <input type="checkbox" name="personal_accepted" {$personal_checked} required>
                [param56]
            </label>
        </div>
    </if>
    <if:[param57]=='Y'>
        <div class="license-item">
            <label>
                <input type="checkbox" name="additional_accepted" {$additional_checked} required>
                [param58]
            </label>
        </div>
    </if>
</div>
